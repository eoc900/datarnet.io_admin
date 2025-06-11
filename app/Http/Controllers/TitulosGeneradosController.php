<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\TituloGenerado;
use App\Services\SoapService;
use App\Models\FormCreator;
use App\Models\XmlZip;
use Illuminate\Support\Facades\Schema;
use App\Helpers\EjemploCertificado;
use App\Helpers\GenerarTitulo;
use SoapClient;
use SoapFault;
use SoapHeader;
use Exception;
use SoapVar;
use ZipArchive;
use SimpleXMLElement;
use Illuminate\Http\Response;

class TitulosGeneradosController extends Controller
{
     public function index(Request $request)
    {
        $searchFor = "";
        $filter = "";
        $page = 1;
        if($request->search != "" && isset($request->search)){
            $searchFor = $request->search;
        }
        if($request->filter != "" && isset($request->filter)){
            $filter = $request->filter;
        }
        if($request->page != "" && isset($request->page)){
            $page = $request->page;
        }
    // -----------> ORIGINAL
    //   $registros = DB::table('titulos_generados')
    //     ->select('titulos_generados.id', DB::raw("CONCAT(modulo_alumnos.nombre,' ',modulo_alumnos.primerApellido,' ',modulo_alumnos.segundoApellido) as alumno"),
    //         'titulos_generados.fecha_expedicion',DB::raw("CONCAT(users.name, ' ', users.lastname) as emitidoPor"),'titulos_generados.estado'
    //     )
    //     ->join('modulo_alumnos','titulos_generados.id_alumno','=','modulo_alumnos.ID_CONTROL')
    //     ->join('users','titulos_generados.emitidoPor','=','users.id')
    //     ->where(DB::raw("CONCAT(modulo_alumnos.nombre,' ',modulo_alumnos.primerApellido,' ',modulo_alumnos.segundoApellido)"),'like', "%{$searchFor}%")
    //     ->orWhere('modulo_alumnos.curp','like', "%{$searchFor}%")
    //     ->orWhere('modulo_alumnos.correoElectronico','like', "%{$searchFor}%");
        
    // -----------> PRUEBAS
      $registros = DB::table('titulos_generados')
        ->select('titulos_generados.id', DB::raw("CONCAT(modulo_alumnos_pruebas.nombre,' ',modulo_alumnos_pruebas.primer_apellido,' ',COALESCE(modulo_alumnos_pruebas.segundo_apellido, '')) as alumno"),
            'titulos_generados.fecha_expedicion',DB::raw("CONCAT(users.name, ' ', users.lastname) as emitidoPor"),'titulos_generados.estado',DB::raw("COALESCE(titulos_generados.num_lote, 'sin asignar') as num_lote")
        )
        ->join('modulo_alumnos_pruebas','titulos_generados.id_alumno','=','modulo_alumnos_pruebas.id_control')
        ->join('users','titulos_generados.emitidoPor','=','users.id')
        ->where(DB::raw("CONCAT(modulo_alumnos_pruebas.nombre,' ',modulo_alumnos_pruebas.primer_apellido,' ',COALESCE(modulo_alumnos_pruebas.segundo_apellido, ''))"),'like', "%{$searchFor}%")
        ->orWhere('modulo_alumnos_pruebas.curp','like', "%{$searchFor}%")
        ->orWhere('modulo_alumnos_pruebas.correo_electronico','like', "%{$searchFor}%")
        ->orWhere('modulo_alumnos_pruebas.id_control','like', "%{$searchFor}%");

       
        
       $titulos_generados = [
            "title"=>"Titulos Generados",
            "titulo_breadcrumb" => "Titulos Generados",
            "subtitulo_breadcrumb" => "Titulos Generados",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"/titulos_generados",
            "confTabla"=>array(
                "tituloTabla"=>"Titulos Generados",
                "placeholder"=>"Buscar titulos_generados",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Por nombre del query"],["key"=>"usuario","option"=>"Nombre usuario"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array('id','alumno','num_lote','estado','fecha_expedicion','emitidoPor'),
                "columns"=>array('Folio','Alumno','Lote Asignado','Estado','Expedido en','Emitido Por'),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(10)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'titulos_generados.destroy',
                "routeCreate" => "titulos_generados.create",
                "routeEdit" => 'titulos_generados.edit', // referente a un método ListadoTitulos Generados
                "routeShow" => 'titulos_generados.show',
                "routeIndex" => 'titulos_generados.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Titulos Generados"
            )];

            return view('sistema_cobros.titulos_generados.index',$titulos_generados);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function actionGenerarTitulo(Request $request){
        
        // Primera validación
        $catalogo_completo = GenerarTitulo::catalogoTablasCompleto();
        if(!$catalogo_completo["estado"]){
            return back()->with("error","Asegúrate que existan todas las tablas, catalogo: ".$catalogo_completo["tabla"]." no encontrado.");
        }

        // Segunda validación
        $request->validate([
            "id_alumno"=>"required|exists:modulo_alumnos_pruebas,id_control",
            "id_institucion"=>"required|exists:modulo_instituciones,id_institucion",
            "cve_carrera"=>"required|exists:modulo_info_carreras_actualizada,cve_carrera",
            "fecha_inicio"=>'nullable|date|date_format:Y-m-d', //opcional
            "fecha_terminacion"=>'required|date|date_format:Y-m-d',
            "id_autorizacion"=>"required|exists:modulo_autorizacion_reconocimiento,id_autorizacion_reconocimiento",
            "id_modalidad"=>"required|exists:modulo_modalidad_titulacion,id_modalidad_titulacion",
            "fecha_examen_profesional"=>"nullable|date|date_format:Y-m-d", //opcional
            "fecha_examen_exencion"=>"nullable|date|date_format:Y-m-d", //opcional
            "servicio_social"=>"required|in:si,no",
            "id_entidad"=>"required|exists:modulo_entidades_federativas,id_excel",
            "id_servicio"=>"required|exists:modulo_servicio_social,id_fundamento_legal_servicio_social",
            "fecha_expedicion"=>'required|date|date_format:Y-m-d',
            "nombre_antecedente"=>'required|string',
            "id_estudio_antecedente"=>'required|exists:modulo_tipo_estudio_antecedente,id_tipo_estudio_antecedente',
            "id_ent_antecedente"=>'required|exists:modulo_entidades_federativas,id_excel',
            "inicio_antecedente"=>'required|date|date_format:Y-m-d',
            "terminacion_antecedente"=>'required|date|date_format:Y-m-d'
        ]);

        //Tercera validación:
        $alumno = DB::table("modulo_alumnos_pruebas")->where("id_control",$request->id_alumno)->first();
        $titulo = TituloGenerado::where("id_alumno",$request->id_alumno)->first();
        if ($titulo) {
            // Si existe el registro, redirigir con un mensaje de advertencia
            return back()->with('error', 'num. control:'.$alumno->id_control.'; este alumno: '.$alumno->nombre.' '.$alumno->primer_apellido.' ya inició su proceso de carga de título');
        }

        //Cuarta validación: Verificar los atributos de registro
        //$alumno = DB::table("modulo_alumnos_pruebas")->where("id_control",$request->id_alumno)->first();
        $carrera = DB::table("modulo_info_carreras_actualizada")->where("cve_carrera",$request->cve_carrera)->first();
        $modalidad = DB::table("modulo_modalidad_titulacion")->where("id_modalidad_titulacion",$request->id_modalidad)->first();
        $entidad = DB::table("modulo_entidades_federativas")->where('id_excel',$request->id_entidad)->first();
        $servicio = DB::table("modulo_servicio_social")->where('id_fundamento_legal_servicio_social',$request->id_servicio)->first();
        $tipo_estudio_antecedente = DB::table("modulo_tipo_estudio_antecedente")->where('id_tipo_estudio_antecedente',$request->id_estudio_antecedente)->first();
        $entidad_antecedente = DB::table("modulo_entidades_federativas")->where('id_excel',$request->id_ent_antecedente)->first();
        $objetos = GenerarTitulo::verificarExistenciaObjetosXML($alumno,$carrera,$modalidad,$entidad,$servicio,$tipo_estudio_antecedente,$entidad_antecedente);
        if(!$objetos[0]){
            return "Hubo un problema: ".$objetos[1];
        }
        //Cuarta validación: Verificar los atributos de registro
        

        // Acomodo de datos de institución antecedente
        $antecedente = ["escuela_antecedente"=>$request->nombre_antecedente,
        "id_tipo_antecedente"=>$request->id_estudio_antecedente,
        "nombre_tipo_antecedente"=>$tipo_estudio_antecedente->tipo_estudio_antecedente,
        "id_entidad_federativa_antecedente"=>$entidad_antecedente->id_excel,
        "entidad_antecedente"=>$entidad_antecedente->entidad,
        "fecha_inicio"=>$request->inicio_antecedente??'',
        "fecha_terminacion"=>$request->terminacion_antecedente??''];


        // Acomodo de datos en arreglos
        $folio_control = Str::random(16);
        $nodoTituloElectronico = GenerarTitulo::atributosTituloElectronico($folio_control);
        $nodoFirmasResponsables = GenerarTitulo::nodoFirmaResponsables();
        $nodoDatosTitulo = GenerarTitulo::datosTitulo($carrera,$request->fecha_terminacion,$alumno,$request->fecha_expedicion,$modalidad,$entidad,$servicio,$request->fecha_examen_profesional,$request->fecha_examen_exencion,$request->fecha_inicio,$antecedente);
        $cadena_original = GenerarTitulo::arregloCadenaOriginal($nodoTituloElectronico,$nodoFirmasResponsables,$nodoDatosTitulo);
        

        //Generar sello
        $Ejemplo = new EjemploCertificado();
        $private_file = storage_path("app/private/llave.key.pem");      // Ruta al archivo key con contraseña
        $public_file = storage_path("app/private/certificado.cer.pem");
        $passcode = env("CLAVE_CODE");
        $resultados = $Ejemplo->firmarCadena($cadena_original, $private_file, $public_file,$passcode);
        if($resultados["verificacion"]){
            $nodoFirmasResponsables["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["sello"] = $resultados["sello"];
        }else{
            Log::channel('titulos')->error('Hubo un error generando el sello');
            return back()->with("error","Hubo un error al generar el sello con la cadena original");
        }

        // Juntar nodos ya con sello
        $xml = GenerarTitulo::topXMLElement($nodoTituloElectronico);
        $tituloElectronico = array_merge($nodoFirmasResponsables,$nodoDatosTitulo);
        $this->arrayToXmlV2($tituloElectronico, $xml);
        $xmlString = GenerarTitulo::retornarXMLString($xml);
       
        // Guardar XML en almacenamiento de Laravel
        $filename = "titulos/".$folio_control.".xml";
        Storage::disk('local')->put($filename, $xmlString);
        Log::channel('titulos')->info('El documento '.$folio_control." fue guardado exitosamente.");

            // Obtener el contenido del archivo recién guardado
        $contenidoXML = Storage::disk('local')->get($filename);
        
        // Codificar documento para enviarlo en carga de titulos
        $base64Xml = base64_encode($contenidoXML);
        // Opcional: Guardar el Base64 en otro archivo o usarlo según sea necesario
        Storage::disk('local')->put("titulos_base64/".$folio_control.".base64", $base64Xml);
        Log::channel('titulos')->info('El documento '.$folio_control.".base64 fue guardado exitosamente.");

        $conf = new GenerarTitulo();

        $TituloGenerado = new TituloGenerado();
        $TituloGenerado->id = $folio_control;
        $TituloGenerado->id_alumno = $alumno->id_control;
        $TituloGenerado->fecha_expedicion = $request->fecha_expedicion;
        $TituloGenerado->estado = 0; // Sin cargar a la plataforma
        $TituloGenerado->emitidoPor = Auth::user()->id;
        $TituloGenerado->id_institucion = $conf->getIDInstitucion();
        $TituloGenerado->cve_carrera = $request->cve_carrera;
        $TituloGenerado->fecha_inicio = $request->fecha_inicio;
        $TituloGenerado->fecha_terminacion = $request->fecha_terminacion;
        $TituloGenerado->modalidad_titulacion = $request->id_modalidad;
        $TituloGenerado->fecha_examen_profesional = $request->fecha_examen_profesional;
        $TituloGenerado->fecha_exencion_examen = $request->fecha_examen_exencion;
        $TituloGenerado->cumplio_servicio_social = ($request->servicio_social=="si")?1:0;
        $TituloGenerado->id_entidad_expedicion  = $request->id_entidad;
        $TituloGenerado->id_servicio_social  = $request->id_servicio;
        $TituloGenerado->id_autorizacion = $request->id_autorizacion;
        $TituloGenerado->nombre_institucion_antecedente = $request->nombre_antecedente;
        $TituloGenerado->tipo_estudio_antecedente = $request->id_estudio_antecedente;
        $TituloGenerado->id_entidad_estudios_antecedentes = $request->id_ent_antecedente;
        $TituloGenerado->fecha_inicio_antecedente = $request->inicio_antecedente;
        $TituloGenerado->fecha_terminacion_antecedente = $request->terminacion_antecedente;
        $TituloGenerado->save();
        Log::channel('titulos')->info('Folio de control: '.$folio_control.' fue almacenado en la base de datos y enlazado al alumno con matricula: '.$alumno->id_control);

        //Pendiente: 
        //Necesito crear una tabla que se llame modulo_titulos va a ser igual a titulos_generados pero con la posibilidad de usar las herramientas 

        return back()->with("success","Preregistro de documento xml exitoso");
        
        


        // return view("sistema_cobros.form_creator.prueba_visual",[
        //                     "title"=>"Ver los datos del formulario",
        //                     "respuesta"=>[
        //                         "folio"=>$folio_control,
        //                         "cadena_original"=>$arreglo_cadena
        //                     ]
        // ]);

    }

    public function reformularTitulosParaXML(Request $request){
        
        $titulosGenerados = TituloGenerado::all();

        foreach($titulosGenerados as $t){
            $nuevoFolio = $t->id;
            //Tercera validación:
            $alumno = DB::table("modulo_alumnos_pruebas")->where("id_control",$t->id_alumno)->first();
            //Cuarta validación: Verificar los atributos de registro
            //$alumno = DB::table("modulo_alumnos_pruebas")->where("id_control",$request->id_alumno)->first();
            $carrera = DB::table("modulo_info_carreras_actualizada")->where("cve_carrera",$t->cve_carrera)->first();
            $modalidad = DB::table("modulo_modalidad_titulacion")->where("id_modalidad_titulacion",$t->modalidad_titulacion)->first();
            $entidad = DB::table("modulo_entidades_federativas")->where('id_excel',$t->id_entidad_expedicion)->first();
            $servicio = DB::table("modulo_servicio_social")->where('id_fundamento_legal_servicio_social',$t->id_servicio_social)->first();
            $tipo_estudio_antecedente = DB::table("modulo_tipo_estudio_antecedente")->where('id_tipo_estudio_antecedente',$t->tipo_estudio_antecedente)->first();
            $entidad_antecedente = DB::table("modulo_entidades_federativas")->where('id_excel',$t->id_entidad_estudios_antecedentes)->first();
            $objetos = GenerarTitulo::verificarExistenciaObjetosXML($alumno,$carrera,$modalidad,$entidad,$servicio,$tipo_estudio_antecedente,$entidad_antecedente);
            if(!$objetos[0]){
                return "Hubo un problema: ".$objetos[1];
            }
            // Acomodo de datos de institución antecedente
            $antecedente = ["escuela_antecedente"=>$t->nombre_institucion_antecedente,
            "id_tipo_antecedente"=>$t->tipo_estudio_antecedente,
            "nombre_tipo_antecedente"=>$tipo_estudio_antecedente->tipo_estudio_antecedente,
            "id_entidad_federativa_antecedente"=>$entidad_antecedente->id_excel,
            "entidad_antecedente"=>$entidad_antecedente->entidad,
            "fecha_inicio"=>$t->fecha_inicio_antecedente??'',
            "fecha_terminacion"=>$t->fecha_terminacion_antecedente??''];

            $nodoTituloElectronico = GenerarTitulo::atributosTituloElectronico($nuevoFolio);
            $nodoFirmasResponsables = GenerarTitulo::nodoFirmaResponsables();
            $nodoDatosTitulo = GenerarTitulo::datosTitulo($carrera,$t->fecha_terminacion,$alumno,$t->fecha_expedicion,$modalidad,$entidad,$servicio,$t->fecha_examen_profesional,$t->fecha_exencion_examen,$t->fecha_inicio,$antecedente);
            $cadena_original = GenerarTitulo::arregloCadenaOriginal($nodoTituloElectronico,$nodoFirmasResponsables,$nodoDatosTitulo);
            
             //Generar sello
            $Ejemplo = new EjemploCertificado();
            $private_file = storage_path("app/private/llave.key.pem");      // Ruta al archivo key con contraseña
            $public_file = storage_path("app/private/certificado.cer.pem");
            $passcode = env("CLAVE_CODE");
            $resultados = $Ejemplo->firmarCadena($cadena_original, $private_file, $public_file,$passcode);
            if($resultados["verificacion"]){
                $nodoFirmasResponsables["FirmaResponsables"]["FirmaResponsable"]["@attributes"]["sello"] = $resultados["sello"];
            }else{
                Log::channel('titulos')->error('Hubo un error generando el sello');
                return back()->with("error","Hubo un error al generar el sello con la cadena original");
            }

               // Juntar nodos ya con sello
            $xml = GenerarTitulo::topXMLElement($nodoTituloElectronico);
            $tituloElectronico = array_merge($nodoFirmasResponsables,$nodoDatosTitulo);
            $this->arrayToXmlV2($tituloElectronico, $xml);
            $xmlString = GenerarTitulo::retornarXMLString($xml);

              // Guardar XML en almacenamiento de Laravel
            $filename = "titulos/".$nuevoFolio.".xml";
            Storage::disk('local')->put($filename, $xmlString);
            Log::channel('titulos')->info('El nuevo documento '.$nuevoFolio." fue guardado exitosamente.");

            // Obtener el contenido del archivo recién guardado
            $contenidoXML = Storage::disk('local')->get($filename);
            
            // Codificar documento para enviarlo en carga de titulos
            $base64Xml = base64_encode($contenidoXML);
            // Opcional: Guardar el Base64 en otro archivo o usarlo según sea necesario
            Storage::disk('local')->put("titulos_base64/".$nuevoFolio.".base64", $base64Xml);
            Log::channel('titulos')->info('El documento '.$nuevoFolio.".base64 fue guardado exitosamente.");

    
            Log::channel('titulos')->info('Folio de control: '.$nuevoFolio.' fue almacenado en la base de datos y enlazado al alumno con matricula: '.$alumno->id_control);


        }

        return response()->json(["respuesta"=>"Xml generados exitosamente por favor verifica los datos."]);
        

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $titulo = DB::table('titulos_generados')
        ->select(
            'titulos_generados.*',
            DB::raw("CONCAT(modulo_alumnos_pruebas.nombre, ' ', modulo_alumnos_pruebas.primer_apellido, ' ', COALESCE(modulo_alumnos_pruebas.segundo_apellido, '')) AS alumno"),
            DB::raw("CONCAT(users.name, ' ', users.lastname) AS emitidoPor")
        )
        ->join('modulo_alumnos_pruebas', 'titulos_generados.id_alumno', '=', 'modulo_alumnos_pruebas.id_control')
        ->join('users', 'titulos_generados.emitidoPor', '=', 'users.id')
        ->where('titulos_generados.id', $id)
        ->firstOrFail(); // Lanza un error 404 si no encuentra el registro


        if(!$titulo){
             return response()->json(["error","Titulo no econtrado","id"=>$id]); 
        }
        return view('sistema_cobros.titulos_generados.show',[
            "title"=>"Información del título",
            "titulo"=>$titulo,
            "id"=>$id
        ]);
    }

    

    public function verXml(Request $request){
        $folio_control = $request->id_titulo;
        // Guardar XML en almacenamiento de Laravel
        $filename = "titulos/".$folio_control.".xml";
        $contenidoXML = Storage::disk('local')->get($filename);
        return response($contenidoXML, 200)
            ->header('Content-Type', 'application/xml')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }

    //---> CARGA DE TÍTULO: Método para generar y carga título de manera individual
    public function pruebaSOAPXml(string $id){
        $titulo = TituloGenerado::find($id);

        if(!$titulo){
            return response()->json(["error","Titulo no econtrado","id"=>$id]); 
        }
        
        $nombre_archivo = $titulo->id.".zip";
        $base64 = Storage::disk('local')->get('zips_base64/'.$titulo->id.".base64");
        $user = env("USER_GDP_PRUEBAS");
        $pass = env("PASS_GDP_PRUEBAS");

        $soap = new SoapService("https://metqa.siged.sep.gob.mx/met-ws/services/TitulosElectronicos.wsdl");
        $response = $soap->generarTituloV2($nombre_archivo, $base64, $user, $pass); // -----> Cambio aquí

        // Aquí si la respuesta es exitosa tenemos que poner el número de lote al que pertenece
        DB::table('titulos_generados')
        ->where('id', $id)
        ->update([
            'num_lote'=>$response["numeroLote"]
        ]);

        return response()->json(["titulo"=>$titulo->id,"response"=>$response,"base64"=>$base64]);
    }

    //---> CONSULTAR LOTE POR ID TITULO: CONSULTA STATUS 
    public function consultarLote(string $id_titulo){
        $titulo = TituloGenerado::find($id_titulo);
        if(!$titulo){
            return response()->json(["error","Titulo no econtrado.","id_titulo"=>$id_titulo]); 
        }
        if(empty($titulo->num_lote)){
            return response()->json(["error","El título no cuenta con un número de lote.","id_titulo"=>$id]); 
        }

        
        $num_lote = $titulo->num_lote;
        $user = env("USER_GDP_PRUEBAS");
        $pass = env("PASS_GDP_PRUEBAS");

        $soap = new SoapService("https://metqa.siged.sep.gob.mx/met-ws/services/TitulosElectronicos.wsdl");
        $response = $soap->consultarLote($num_lote,$user, $pass);
        return response()->json(["titulo"=>$titulo->id,"response"=>$response]);
    }



public function descargarLote(string $id_titulo)
{
    $titulo = TituloGenerado::where("num_lote", $id_titulo)->first();
    if (!$titulo) {
        return response()->json(["error" => "Título no encontrado.", "num_lote" => $id_titulo]);
    }
    if (empty($titulo->num_lote)) {
        return response()->json(["error" => "El título no cuenta con un número de lote.", "num_lote" => $id_titulo]);
    }

    $num_lote = $titulo->num_lote;
    $user = env("USER_GDP_PRUEBAS");
    $pass = env("PASS_GDP_PRUEBAS");

    $soap = new SoapService("https://metqa.siged.sep.gob.mx/met-ws/services/TitulosElectronicos.wsdl");
    $response = $soap->descargarLoteV2($num_lote, $user, $pass,$id_titulo);

    $respuesta = $this->procesarXML();

    return $respuesta;
}

function procesarXML() {
    // Ruta del archivo XML en el storage de Laravel
    $xmlPath = storage_path('app/soap_requests/ultimo_response.xml');

    // Verifica si el archivo existe
    if (!file_exists($xmlPath)) {
        throw new Exception("El archivo XML no existe en la ruta especificada: $xmlPath");
    }

    // Cargar el XML
    $xmlContent = file_get_contents($xmlPath);
    $xml = new SimpleXMLElement($xmlContent);

    // Extraer el namespace correcto
    $namespaces = $xml->getNamespaces(true);
    $body = $xml->children($namespaces['env'])->Body;
    $response = $body->children($namespaces[''])->descargaTituloElectronicoResponse;

    if (!$response) {
        throw new Exception("No se pudo extraer la respuesta del XML.");
    }

    // Obtener valores
    $numeroLote = (string) $response->numeroLote;
    $titulosBase64 = (string) $response->titulosBase64;
    Storage::disk('local')->put('soap_requests/titulos_base64.txt', $titulosBase64);

    if (empty($titulosBase64) || empty($numeroLote)) {
        throw new Exception("No se encontraron los valores esperados en el XML.");
    }

    // Decodificar el contenido Base64
    $decodedData = base64_decode($titulosBase64);

    if ($decodedData === false) {
        throw new Exception("Error al decodificar el contenido Base64.");
    }

    // Crear carpeta de destino si no existe
    $directory = storage_path('app/respuestas_descargas_lotes');
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    // Nombre del archivo de salida
    $fileName = "ResultadoCargaTitulos{$numeroLote}.zip";
    $filePath = $directory . '/' . $fileName;

    // Guardar el archivo
    file_put_contents($filePath, $decodedData);

    return response()->json(["respuesta"=>"Archivo guardado en: $filePath"]);
}


    public function generarZipDocumentos(Request $request) {
        $str_documentos = $request->seleccionados;
        $titulo = new GenerarTitulo();

        if (!is_array($str_documentos) || count($str_documentos) <= 1) {
            return response()->json(["error" => "Por favor selecciona más de un registro para generar un archivo .zip de archivo xml adjuntos."], 400);
        }

        if (!Auth::check()) {
            return response()->json(["error" => "No estás autenticado."], 401);
        }

        // 1. Generar un nombre para el archivo ZIP
        $nombre_zip = "titulos_xml_" . now()->format('Y_m_d') . "_" . Str::random(10) . "_" . count($str_documentos);
        
        // 2. Generar el ZIP en la carpeta storage/app/zips/
        $zip_base64 = $titulo->generarZipBase64Simple($str_documentos, $nombre_zip);

        // 3. Verificar que el ZIP realmente se haya generado
        $zipPath = storage_path("app/zips/$nombre_zip.zip");

        if (!file_exists($zipPath)) {
            return response()->json(["error" => "El archivo ZIP no se encontró en el servidor."], 500);
        }

        // 4. Convertir el ZIP a Base64
        // $zipContent = file_get_contents($zipPath);
        // $base64Zip = base64_encode($zipContent);

            //Agregado para pruebas
            $base64Path = "zips_base64/{$nombre_zip}.base64";

            // Verificar si el archivo base64 existe en Storage
            if (!Storage::disk('local')->exists($base64Path)) {
                return response()->json(["error" => "El archivo Base64 no fue encontrado."], 404);
            }

            // Obtener el contenido Base64
            $base64Content = Storage::disk('local')->get($base64Path);

   

        // 7. Enviar el ZIP codificado a Base64 al servicio SOAP
        $nombre_archivo = $nombre_zip . ".zip";
        $user = env("USER_GDP_PRUEBAS");
        $pass = env("PASS_GDP_PRUEBAS");

        try {
            Storage::disk('local')->put('debug_base64_guardado.txt', $base64Content);
            Storage::disk('local')->put('debug_base64_generado.txt', base64_encode(file_get_contents($zipPath)));

            Storage::disk('local')->put('valor_base64/antes_de_enviar.xml',$base64Content);
            $soap = new SoapService("https://metqa.siged.sep.gob.mx/met-ws/services/TitulosElectronicos.wsdl");
            $response = $soap->generarTituloV2($nombre_archivo, $base64Content, $user, $pass);
            Log::channel('titulos')->info(json_encode($response));
        } catch (Exception $e) {
            Log::channel('titulos')->error('Error en el servicio SOAP: ' . $e->getMessage());
            return response()->json(["error" => "Error al comunicarse con el servicio de titulación electrónica."], 500);
        }

        // 8. Si el servicio SOAP devuelve un número de lote, guardarlo en la base de datos
        if (isset($response->numeroLote)) {
            foreach ($zip_base64["archivos_utilizados"] as $folio) {
                $titulo = TituloGenerado::find($folio);
                if ($titulo) {
                    $titulo->num_lote = $response->numeroLote;
                    $titulo->save();
                }
            }
        }

             // 5. Guardar el ZIP en la base de datos
            $zips = new XmlZip();
            $zips->nombre = $nombre_zip . ".zip";
            $zips->lote = $response->numeroLote;
            //$zips->base64_zip = $base64Zip; // Agregar campo base64 en la base de datos si aún no existe
            $zips->creadoPor = Auth::user()->id;
            $zips->save();


            // 6. Asignar el ID del ZIP a los títulos generados
            foreach ($zip_base64["archivos_utilizados"] as $folio) {
                $titulo = TituloGenerado::find($folio);
                if ($titulo) {
                    $titulo->archivo_zip = $zips->id;
                    $titulo->save();
                }
            }


        return response()->json([
            "titulos" => $str_documentos,
            "base64" =>  $base64Content, 
            "response" => $response
        ]);
    }

   public function descargarZipDesdeBase64(Request $request)
{

        $request->validate([
            'nombre_zip' => 'nullable|string',
            'lote' => 'nullable|string'
        ]);

        // Asegurarse de que al menos uno de los dos campos esté presente
        if (empty($request->nombre_zip) && empty($request->lote)) {
            return response()->json(["error" => "Se requiere al menos nombre_zip o lote"], 400);
        }

        $nombre_zip = $request->nombre_zip;
        $lote = $request->lote;

        // Caso 1: Si no hay lote pero sí nombre_zip, buscar el lote
        if (empty($lote) && !empty($nombre_zip)) {
            $resultado = XmlZip::where("nombre", $nombre_zip)->first();
            if ($resultado) {
                $lote = $resultado->lote;
            } else {
                return response()->json(["error" => "No se encontró un lote para el nombre_zip proporcionado"], 404);
            }
        } 
        // Caso 2: Si no hay nombre_zip pero sí lote, buscar el nombre_zip
        elseif (empty($nombre_zip) && !empty($lote)) {
            $resultado = XmlZip::where("lote", $lote)->first();
            if ($resultado) {
                $nombre_zip = $resultado->nombre;
            } else {
                return response()->json(["error" => "No se encontró un nombre_zip para el lote proporcionado"], 404);
            }
        }

   

    // Nombre del archivo ZIP sin extensión
    $filename = pathinfo($nombre_zip, PATHINFO_FILENAME);

    // Ruta del archivo base64
    $base64Path = "zips_base64/{$filename}.base64";

    // Verificar si el archivo base64 existe en Storage
    if (!Storage::disk('local')->exists($base64Path)) {
        return response()->json(["error" => "El archivo Base64 no fue encontrado."], 404);
    }

    // Obtener el contenido Base64
    $base64Content = Storage::disk('local')->get($base64Path);

    // Decodificar el Base64 a binario
    $zipContent = base64_decode($base64Content);

    // Definir la ruta del archivo ZIP decodificado
    $zipDecodedPath = storage_path("app/zips_decodificados/{$filename}.zip");

    // Guardar el ZIP decodificado en Storage
    Storage::disk('local')->put("zips_decodificados/{$filename}.zip", $zipContent);

    // Verificar si el archivo realmente es un ZIP
    $handle = fopen($zipDecodedPath, 'rb');
    $signature = fread($handle, 4);
    fclose($handle);

    if ($signature !== "\x50\x4B\x03\x04") {
        return response()->json(["error" => "El archivo decodificado no es un ZIP válido."], 400);
    }

    // Crear una URL temporal para la descarga
    $downloadUrl = route('descargar.zip.temporal', ['filename' => $filename]);

    // Mostrar la vista con el contenido Base64 y la URL de descarga
    return view('sistema_cobros.titulos_generados.mostrar_base64', [
        'title'=>"prueba visualización",
        'base64Content' => $base64Content,
        'filename' => $filename,
        'downloadUrl' => $downloadUrl,
        'lote'=>$lote
    ]);
}

public function descargarZipTemporal($filename)
{
    $zipDecodedPath = storage_path("app/zips_decodificados/{$filename}.zip");
    
    return response()->download($zipDecodedPath, "{$filename}.zip")->deleteFileAfterSend();
}




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->can('Eliminar prueba titulo')){
        $record = TituloGenerado::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'Titulo eliminado con éxito.');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
        }
        return back()->with('error', 'No cuentas con el permiso para eliminar pruebas');
    }

    private function arrayToXmlV2($data, &$xml) {
    foreach ($data as $key => $value) {
        // Si es un atributo, se agrega directamente
        if ($key === '@attributes') {
            foreach ($value as $attr => $attrValue) {
                if ($attrValue !== '') { // ⬅️ No agregar atributos vacíos
                    $xml->addAttribute($attr, $attrValue);
                }
            }
        } else {
            // Si es un array, se agrega como un nuevo nodo
            if (is_array($value)) {
                if (isset($value['@attributes'])) {
                    // Si tiene atributos, creamos el nodo y le asignamos atributos
                    $subnode = $xml->addChild($key);
                    foreach ($value['@attributes'] as $attr => $attrValue) {
                        if ($attrValue !== '') { // ⬅️ No agregar atributos vacíos
                            $subnode->addAttribute($attr, $attrValue);
                        }
                    }
                    unset($value['@attributes']); // Evitar que los atributos se inserten como nodos
                } else {
                    $subnode = $xml->addChild($key);
                }
                $this->arrayToXmlV2($value, $subnode);
            } else {
                if ($value !== '') { // ⬅️ No agregar nodos con valores vacíos
                    $xml->addChild($key, htmlspecialchars($value));
                }
            }
        }
    }
    }
    
    public function probarConexion(){
            $options = [
                'trace' => true,
                'cache_wsdl' => WSDL_CACHE_NONE,
                'soap_version' => SOAP_1_1,
                'stream_context' => stream_context_create([
                    'ssl' => [
                        'cafile' => storage_path('certs/cacert.pem'),
                        'verify_peer' => true, 
                        'verify_peer_name' => true,
                    ],
                ]),
            ];

            try {
                $client = new SoapClient('https://metqa.siged.sep.gob.mx/met-ws/services/TitulosElectronicos.wsdl', $options);
                echo "Conexión exitosa";
            } catch (Exception $e) {
                echo "Error SOAP: " . $e->getMessage();
            }

    }
}
