<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cobro;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Cuenta;
use App\Services\DatabaseService;
use App\Helpers\DashboardsGraphs;
use App\Models\SQLCreator;
use App\Models\TipoDato;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Helpers\TablasModulos;
use App\Helpers\Informes;


class AjaxHtmlController extends Controller
{
    public function tablaCobros(Request $request){
        $datos = array();
        if(isset($request->id_cuenta)){
            $idCuenta = $request->id_cuenta;
            $datos = Cobro::cobrosRelacionadosCuenta($idCuenta);
        }

        $array = array( 'data'=>$datos->paginate(14),
                        'renderSectionID'=>'cobros_cuenta',
                        'rowActions'=>array("show","edit","destroy"),
                        "keys"=>array('codigo_concepto','estado','costo','fecha_inicio','fecha_fin'),
                        "columns"=>array("Concepto","Estado","Costo","Inicia","Finaliza"),
                        "routeDestroy" => 'cobros.destroy',
                        "routeCreate" => 'cobros.create',
                        "routeEdit" => 'cobros.edit',
                        "routeShow" => 'cobros.show',
                        "idKeyName"=>"id",
                        "rowCheckbox"=>true,
                        "routeIndex"=>'cobros');
       return view('sistema_cobros.htmlForAjaxResponse.table_cobros_periodo',$array);
    }

    public function listaRolesUsuario(Request $request){
        $datos = array();
        if(isset($request->id_usuario)){
            $datos = DB::table("users")->select('users.id',
                    DB::raw('CONCAT(users.name," ",users.lastname) as usuario'), 'roles.name as role','roles.id as roleID')
                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','=','roles.id')
                ->where('users.id','=',$request->id_usuario)
                ->get();
         
        }
        return view('sistema_cobros.htmlForAjaxResponse.listaRolesUsuario',["datos"=>$datos]);
    }

    public function sistemasAcademicosEscuela(Request $request){
        // return DB::table('sistemas_academicos')->where('id_escuela','=',$request->input("id_escuela"));
        $id_escuela = $request->input('id_escuela');
        $sistema = $request->input('seleccionado');

        if($sistema){
            $response = DB::table('sistemas_academicos')
            ->where('id_escuela','=',$request->input("id_escuela"))
            ->get();
        }
        if($sistema==="" || $sistema==null){
            $response = DB::table('sistemas_academicos')->where('id_escuela','=',$request->input("id_escuela"))->get();
        }
        
        return view('sistema_cobros.htmlForAjaxResponse.dropdownSistemasAc',["sistemas"=>$response,"seleccionado"=>$sistema]);
    }


    public function cuentasDeAlumno(Request $request){
        $id_alumno = $request->input('id_alumno');

        // $response = DB::table('cuentas')->select('cuentas.cuatrimestre','cuentas.id','cuentas.fecha_inicio','cuentas.vencimiento',
        // DB::raw('SUM(desglose_cuentas.monto) as total_cargos'),DB::raw('SUM(pagos_realizados.monto) as total_pagos'))
        // ->leftJoin('desglose_cuentas','cuentas.id','=','desglose_cuentas.id_cuenta')
        // ->leftJoin('pagos_realizados','cuentas.id','=','pagos_realizados.id_cuenta')
        // ->where('cuentas.id_alumno','=',$id_alumno)
        // ->groupBy('cuentas.id')
        // ->get();

        $response = DB::table('cuentas')
        ->select('cuentas.cuatrimestre', 'cuentas.id', 'cuentas.fecha_inicio', 'cuentas.vencimiento')
        ->selectSub(function ($query) {
            $query->from('desglose_cuentas')
                ->selectRaw('SUM(monto)')
                ->whereColumn('desglose_cuentas.id_cuenta', 'cuentas.id');
        }, 'total_cargos')
        ->selectSub(function ($query) {
            $query->from('pagos_realizados')
                ->selectRaw('SUM(monto)')
                ->whereColumn('pagos_realizados.id_cuenta', 'cuentas.id');
        }, 'total_pagos')
        ->where('cuentas.id_alumno', '=', $id_alumno)
        ->groupBy('cuentas.id', 'cuentas.cuatrimestre', 'cuentas.fecha_inicio', 'cuentas.vencimiento')
        ->get();


        return view('sistema_cobros.htmlForAjaxResponse.dropdownCuentasAlumnos',["cuentas"=>$response]);

    }

    public function cargosDeCuentaAlumno(Request $request){
        $cuenta = $request->id_cuenta;
        $response = DB::table('desglose_cuentas')->select('desglose_cuentas.num_cargo','desglose_cuentas.monto as monto_real','desglose_cuentas.fecha_inicio',
        'desglose_cuentas.fecha_finaliza','costo_concepto_cobros.costo','conceptos_cobros.codigo_concepto')
        ->join('costo_concepto_cobros','desglose_cuentas.id_monto','=','costo_concepto_cobros.id')
        ->join('conceptos_cobros','costo_concepto_cobros.id_concepto','=','conceptos_cobros.id')
        ->where('desglose_cuentas.id_cuenta','=',$cuenta)
        ->get();
        
        return view('sistema_cobros.htmlForAjaxResponse.tablaCargosCuenta',['cargos'=>$response]);
     
    }

     public function pagosDeCuentaAlumno(Request $request){
        $cuenta = $request->id_cuenta;
        $response = DB::table('pagos_realizados')->select('pagos_realizados.tipo_pago','pagos_realizados.monto','pagos_realizados.created_at')
        ->where('pagos_realizados.id_cuenta','=',$cuenta)
        ->get();
        return view('sistema_cobros.htmlForAjaxResponse.tablaPagosRealizados',['pagos'=>$response]);
    }


    public function conceptosRelacionadosAlumno(Request $request){
        // Con el id de alumno vemos que conceptos podemos cargarle acorde al sistema acadêmico
        $id_alumno = $request->input('id_alumno');
        $id_cuenta = $request->input('id_cuenta');
        if($id_cuenta==="" || $id_cuenta==null){
            $response = DB::table('alumnos')->select('alumnos.id_sistema_academico','conceptos_cobros.nombre','conceptos_cobros.id',
            'costo_concepto_cobros.costo','costo_concepto_cobros.periodo')
            ->join('sistemas_academicos','alumnos.id_sistema_academico','=','sistemas_academicos.id')
            ->join('conceptos_cobros','sistemas_academicos.id','=','conceptos_cobros.sistema_academico')
            ->leftJoin('costo_concepto_cobros','conceptos_cobros.id','=','costo_concepto_cobros.id_concepto')
            ->where('alumnos.id', '=', $id_alumno)
            ->get();
        }
        if($id_cuenta!=="" || $id_cuenta!=null){
            $periodo = DB::table('cuentas')->select('cuentas.cuatrimestre')->where('id','=',$id_cuenta);
            $response = DB::table('alumnos')->select('alumnos.id_sistema_academico','conceptos_cobros.nombre','conceptos_cobros.id',
            'costo_concepto_cobros.costo','costo_concepto_cobros.periodo','costo_concepto_cobros.id as id_costo')
            ->join('sistemas_academicos','alumnos.id_sistema_academico','=','sistemas_academicos.id')
            ->join('conceptos_cobros','sistemas_academicos.id','=','conceptos_cobros.sistema_academico')
            ->leftJoin('costo_concepto_cobros','conceptos_cobros.id','=','costo_concepto_cobros.id_concepto')
            ->where('alumnos.id', '=', $id_alumno)
            ->where('costo_concepto_cobros.periodo','=',$periodo)
            ->get();
        }

        return view('sistema_cobros.htmlForAjaxResponse.dropdownCostos',['costos'=>$response]);

    }

    public function previewCuenta(Request $request){
               //$escuela = DB::table('sistemas_academicos')->where('sistemas_academicos.id_escuela','=',)->firstOrFail();
        Carbon::setLocale('es'); // Configura el idioma a español
        $cuenta = new Cuenta();
        $resultados = $cuenta->datosParaGenerarDocumento($request->id_cuenta);
      
        return view('pdfs.plantilla_preview',$resultados);
    }
    
    public function checkboxPagosPendientes(Request $request){
        $cuenta = $request->id_cuenta;
        $response = DB::table('desglose_cuentas')->select('desglose_cuentas.id','desglose_cuentas.num_cargo','desglose_cuentas.monto as monto_real','desglose_cuentas.fecha_inicio',
        'desglose_cuentas.fecha_finaliza','costo_concepto_cobros.costo','conceptos_cobros.codigo_concepto')
        ->join('costo_concepto_cobros','desglose_cuentas.id_monto','=','costo_concepto_cobros.id')
        ->join('conceptos_cobros','costo_concepto_cobros.id_concepto','=','conceptos_cobros.id')
        ->where('desglose_cuentas.id_cuenta','=',$cuenta)
        ->get();
        return view('sistema_cobros.htmlForAjaxResponse.checkboxPagosPendientes',['cargos'=>$response]);
    }

    public function inputCorreo(Request $request){
        $tipos_correos = DB::table('tipos_correos')->get();
        return view('sistema_cobros.htmlForAjaxResponse.inputCorreo',['tipos_correos'=>$tipos_correos]);
    }

    public function periodosInscripciones(Request $request){
        return view('sistema_cobros.htmlForAjaxResponse.checkboxPagosPendientes',['cargos'=>$response]);
    }


    public function inscripcionesAlumno(Request $request){
        $inscripciones = DB::table('inscripciones')
        ->select('inscripciones.id','inscripciones.periodo','inscripciones.inscrito_por','inscripciones.tipo_inscripcion',
            DB::raw('COUNT(carga_materias.id) as materias_inscritas'))
        ->leftJoin('carga_materias', 'inscripciones.id', '=', 'carga_materias.id_inscripcion')
        ->groupBy('inscripciones.id','inscripciones.periodo')
        ->get();
    }

    public function columnasTablaModulo(Request $request){

        
        $request->validate([
            "tabla"=>"string|max:64|required",
            "index"=>"nullable|integer"
        ]);
        $columnas = DatabaseService::obtenerColumnasDeTabla($request->tabla,["updated_at","created_at"]);

        //return response()->json(["request"=>$request->all(),"columnas_encontradas"=>$columnas]);
        if($request->input("only_columnas")){
            return view('sistema_cobros.htmlForAjaxResponse.dropdownColumnasTablaModulo',[
            'columnas'=>$columnas,
            'tabla'=>$request->tabla,
            'arrastrable'=>$request->arrastrable??"",
            'only_columnas'=>(isset($request->only_columnas)?true:null),
            'excel'=>$request->input("excel")??false,
            'index'=>$request->index??"",
            'multi_item'=>$request->input("multi_item")??false, // para poder asignar bien el name="campos[$tabla][$index][on_row]"
            'multi_item_tabla'=>$request->input("multi_item_tabla")??false,
            'multi_item_index'=>$request->input("multi_item_index")??false
            ]);
        }

        if($request->input("drag_drop")){
            return view('sistema_cobros.htmlForAjaxResponse.dropdownColumnasTablaModulo',[
            'columnas'=>$columnas,
            'tabla'=>$request->tabla,
            'arrastrable'=>$request->arrastrable??"",
            'drag_drop'=>(isset($request->drag_drop)?true:null),
            'index'=>$request->index??""
            ]);
        }


        return view('sistema_cobros.htmlForAjaxResponse.dropdownColumnasTablaModulo',[
            'columnas'=>$columnas,
            'tabla'=>$request->tabla,
            'arrastrable'=>$request->arrastrable??""
        ]);
    }

    public function dropdownJoins(Request $request){
        return view('sistema_cobros.htmlForAjaxResponse.dropdownJoins');
    }

    public function dropdownWhereOperators(){
        return view('sistema_cobros.htmlForAjaxResponse.dropdownWhereOperators');
    }

    public function whereValueInput(){
        return view('sistema_cobros.htmlForAjaxResponse.whereValueInput');
    }
    public function dropdownFuncionesAgregadas(Request $request){
        $request->validate([
            "columna"=>"string|max:64|required"
        ]);
        return view('sistema_cobros.htmlForAjaxResponse.dropdownFuncionesAgregadas',["columna"=>$request->columna]);
    }

    public function dropdownWhereLogicOperators(Request $request){
        if(in_array($request->logical,["first","and","or"])){
            return view('sistema_cobros.htmlForAjaxResponse.dropdownWhereLogicOperators',["selected"=>$request->logical]);
        }else{
            return "operador no encontrado :".$request->logical."|";
        }
    }

    public function selectFuncionFechas(Request $request){
        return view('sistema_cobros.htmlForAjaxResponse.dropdownFuncionFechas');
    }

    public function formCreatorInputSelection(){
        return view('components.form_creator.dropdown_select_input_type');
    }
    public function formCreatorDropdownInputConfig(Request $request){
        $tablas = DatabaseService::obtenerTablasConPrefijo('modulo_');
        $subcampo = filter_var($request->input("es_subcampo", true), FILTER_VALIDATE_BOOLEAN);
        return view('components.form_creator.dropdown_config',["tablas"=>$tablas,"subcampo"=>$subcampo,"i"=>$request->input("index")]);
    }
    public function formCreatorSelect2InputConfig(Request $request){
        $tablas = DatabaseService::obtenerTablasConPrefijo('modulo_');
        $subcampo = filter_var($request->input("es_subcampo", true), FILTER_VALIDATE_BOOLEAN);
        return view('components.form_creator.select2_config',["tablas"=>$tablas,"tabla_arrastrable"=>true,"subcampo"=>$subcampo,"i"=>$request->input("index")]);
    }
    public function formCreatorRadioConfig(Request $request){
        $subcampo = filter_var($request->input("es_subcampo", true), FILTER_VALIDATE_BOOLEAN);
        return view('components.form_creator.radio_config',["subcampo"=>$subcampo,"i"=>$request->input("index")]);
    }
    public function formCreatorDateConfig(Request $request){
        $subcampo = filter_var($request->input("es_subcampo", true), FILTER_VALIDATE_BOOLEAN);
        return view('components.form_creator.date_config',["subcampo"=>$subcampo,"i"=>$request->input("index")]);
    }
     public function formCreatorTimeConfig(Request $request){
        $subcampo = filter_var($request->input("es_subcampo", true), FILTER_VALIDATE_BOOLEAN);
        return view('components.form_creator.time_config',["subcampo"=>$subcampo,"i"=>$request->input("index")]);
    }
    public function formCreatorDatetimeConfig(Request $request){
        $subcampo = filter_var($request->input("es_subcampo", true), FILTER_VALIDATE_BOOLEAN);
        return view('components.form_creator.datetime_config',["subcampo"=>$subcampo,"i"=>$request->input("index")]);
    }
    public function formCreatorTextConfig(Request $request){
        $subcampo = filter_var($request->input("es_subcampo", true), FILTER_VALIDATE_BOOLEAN);
        return view('components.form_creator.text_config',["subcampo"=>$subcampo,"i"=>$request->input("index")]);
    }
    public function formCreatorEmailConfig(Request $request){
        $subcampo = filter_var($request->input("es_subcampo", true), FILTER_VALIDATE_BOOLEAN);
        return view('components.form_creator.email_config',["subcampo"=>$subcampo,"i"=>$request->input("index")]);
    }
    public function formCreatorFileConfig(Request $request){
        $subcampo = filter_var($request->input("es_subcampo", true), FILTER_VALIDATE_BOOLEAN);
        return view('components.form_creator.file_config',["subcampo"=>$subcampo,"i"=>$request->input("index")]);
    }
    public function formCreatorCheckboxConfig(Request $request){
        $subcampo = filter_var($request->input("es_subcampo", true), FILTER_VALIDATE_BOOLEAN);
        return view('components.form_creator.checkbox_config',["subcampo"=>$subcampo,"i"=>$request->input("index")]);
    }
    public function formCreatorHiddenInputConfig(Request $request){
        $subcampo = filter_var($request->input("es_subcampo", true), FILTER_VALIDATE_BOOLEAN);
        return view('components.form_creator.hidden_input_config',["subcampo"=>$subcampo,"i"=>$request->input("index")]);
    }
    public function formCreatorMultiItemConfig(Request $request){
        $subcampo = filter_var($request->input("es_subcampo", true), FILTER_VALIDATE_BOOLEAN);
        return view('components.form_creator.modales.multi_item_config',['i'=>$request->input("index")]);
    }
    public function cajaValidacion(Request $request){
        $index = $request->input('index');
        return view('sistema_cobros.form_creator.components.caja_validacion', ['index' => $index]);
    }
    public function tipoDatoReglaValidacion(Request $request){
        $tipo = $request->input('tipo_dato');
        $index = $request->input('index');
       switch ($tipo) {
            case 'string':
                return view('sistema_cobros.form_creator.components.validaciones.string', compact('index'));
            
            case 'numeric':
            case 'integer':
                return view('sistema_cobros.form_creator.components.validaciones.numeric', compact('index'));

            case 'array':
                return view('sistema_cobros.form_creator.components.validaciones.array', compact('index'));

            case 'boolean':
                return view('sistema_cobros.form_creator.components.validaciones.boolean', compact('index'));

            case 'date':
                return view('sistema_cobros.form_creator.components.validaciones.date', compact('index'));
            case 'time':
                return view('sistema_cobros.form_creator.components.validaciones.date', compact('index'));
            case 'email':
                return view('sistema_cobros.form_creator.components.validaciones.email', compact('index'));

            case 'uuid':
                return view('sistema_cobros.form_creator.components.validaciones.uuid', compact('index'));

            case 'url':
                return view('sistema_cobros.form_creator.components.validaciones.url', compact('index'));

            case 'ip':
                return view('sistema_cobros.form_creator.components.validaciones.ip', compact('index'));

            case 'json':
                return view('sistema_cobros.form_creator.components.validaciones.json', compact('index'));

            case 'image':
                return view('sistema_cobros.form_creator.components.validaciones.image', compact('index'));

            case 'file':
                return view('sistema_cobros.form_creator.components.validaciones.file', compact('index'));

            default:
                return ''; // O puedes retornar una vista vacía o mensaje informativo
        }

    }

    //-----> MOSTRAR ELEMENTOS DE INFORMES
    public function informesRenderElementoConfig(Request $request){

        $validated = $request->validate([
            'col' => 'nullable|string',
            'index' => 'required|string',
            'tipo_elemento' => 'required|string',
        ]);

        $col = $validated["col"] ?? null;
        $index = $request->input("index");
        $tipo = $request->input("tipo_elemento");
        $objeto = [];

        // Obtener el arreglo del archivo de configuración del informe
        $estructura = json_decode(Storage::get("informes/tmp/config_temp.json"), true);
        if (!is_array($estructura)) {
            $estructura = ['secciones' => []];
        }
        // Generar  un id
        $id = Str::random(5);
        // Generar un objeto para guardar ese elemento
        $objeto["tipo"]=$tipo;
        $objeto["id"]=$id;
        $objeto["col"]=$col;
        $objeto["index"]=$index;
        // Guardar el nuevo objeto en en secciones
        $path = 'informes/tmp/config_temp.json';
        $estructura["secciones"][] = $objeto;
        Storage::put($path, json_encode($estructura, JSON_PRETTY_PRINT));

        return view('sistema_cobros.informes.componentes.render_config',$objeto);
    }
    //-----> MOSTRAR ELEMENTOS DE INFORMES
    public function dropdownGraficas(){
        return view('components.dashboard.dropdown_charts');
    }
    public function ejemploGraficas(Request $request){
        $dashboard = new DashboardsGraphs();
        $ejemplo = $dashboard->getExampleResult($request->ejemplo);
        $campos = [];
        if($request->ejemplo=="barchart"){
            $campos = ["fecha","total"];
        }
        if($request->ejemplo=="piechart"){
            $campos = ["categoria","porcentaje"];
        }
        if($request->ejemplo=="linechart"){
            $campos = ["fecha","valor"];
        }
        if($request->ejemplo=="areachart"){
            $campos = ["fecha","valor"];
        }
        return response()->json(["datos"=>$ejemplo,"campos"=>$campos,"chart"=>$request->ejemplo]);
    }
    public function dataGraficas(Request $request){
        $query = SQLCreator::findOrFail($request->id);
        $chart = $request->chart;
        if($query){
            $dashboard = new DashboardsGraphs();
            $data = Storage::disk('local')->get('queries/'.$query->nombre.'.json');
            $json = json_decode($data, true);
            $resultados = [];
            if($chart=="areachart"){
                $resultados = $dashboard->areaChartQuery($json["tablas"][0], $json["agrupar"][0], $json["agrupar"][0],"mes","conteo",false,["2021-01-01","2021-02-01"],[]);
            }
            return ["resultados"=>$resultados,"chart"=>$chart];
        }
       
    }

    public function queryConfigurationGraph(Request $request){
        
        $query = SQLCreator::findOrFail($request->id);
        $tipo_grafica = $request->tipo_grafica;
        $nombre_query = $query->nombre;
        $ruta = 'queries/' . $nombre_query.".json";
        if (Storage::disk('local')->exists($ruta)){
            $data = Storage::disk('local')->get($ruta);
            $jsonDecoded = json_decode($data, true);
            $dashboard = new DashboardsGraphs();
            $resultados = $dashboard->consultaFormatoGrafico($jsonDecoded, $tipo_grafica); 
            return response()->json(["datos"=>$resultados,"tipo_grafica"=>Str::lower($tipo_grafica)]);
        }
        return response()->json(["datos"=>[],"tipo_grafica"=>Str::lower($tipo_grafica)]);
    }


    public function campoSelect2(Request $request){
        return view('components.sistema_cobros.select2',["id"=>$request->id,"placeholder"=>$request->placeholder,"name"=>$request->name]);
    }

    public function renderEditInputsFormCreator(Request $request){
        $documento = $request->documento;
        $ruta = 'formularios/' . $documento;
        if (Storage::disk('local')->exists($ruta)) {
            // El documento existe, procedemos a obtenerlo y decodificarlo
            $data = Storage::disk('local')->get($ruta);
            $jsonDecoded = json_decode($data, true);
            $tablas = DatabaseService::obtenerTablasConPrefijo('modulo_');
            return view('components.form_creator.render_campos_documento',["documento"=>$jsonDecoded,"tablas"=>$tablas]);
            // Aquí puedes continuar con tu lógica de negocio
        } else {
            // El documento no existe, manejamos el error o la ausencia del documento
            return '<div class="alert alert-warning">No se encontró el documento que estás buscando</div>';
        }
    }

    public function renderInputsTabla(Request $request){
        // USO: para agregar los inputs cuando se crea un formulario
        $id = $request->id;
        //1. Conseguir las columnas correspondientes a la tabla y el tipo de dato que es
        $resultados = DatabaseService::obtenerColumnasTipoDato($id);
        return view("components.form_creator.render_inputs_tabla_db",["columnas"=>$resultados]);
    }

    public function tablasModulosBuscarEnColumna(Request $request){
        $tabla = $request->tabla;
        $columna = $request->columna;
        $valor = $request->buscar;

        $TablasHelper = new TablasModulos();
        $columnas_db = $TablasHelper->obtenerColumnasTablaDB($tabla, ["created_at", "updated_at"]);

        $resultados = DB::table($tabla)
            ->select($columnas_db)
            ->where($columna, "like", "%{$valor}%")
            ->get();

        $sql = DB::table($tabla)
        ->select($columnas_db)
        ->where($columna, 'like', "%{$valor}%")
        ->toSql();

        return view("components.form_creator.componentes_busqueda.tabla_resultados_ajax", [
            "resultados" => $resultados,
            "columnas" => $columnas_db,
            "sql"=>$sql,
            "tabla"=>$tabla
        ]);
    }

    public function tiposDatosDropdown(Request $request){
        $name = $request->name;
        $index = $request->index;
        $tabla = $request->tabla;
        $tipos_datos = TipoDato::all();
        $tablas_disponibles = DatabaseService::obtenerTablasConPrefijo('modulo_');
        return view("components.form_creator.tipos_datos_dropdown",
        ["tipos_datos"=>$tipos_datos,"name"=>$name,"index"=>$index, "tablas"=>$tablas_disponibles,"tabla"=>$tabla]);
    }


    public function configElementDataInformes(Request $request){
        // Ruta de guardado : "informes/tmp/config_temp.json"
        $id = $request->element;
        $id_informe = $request->input('id_informe')??'';
        $edicion = $request->input('edicion');

        // 1. Obtener las tablas
        $tablas = DatabaseService::obtenerTablasConPrefijo('modulo_');

        // 2. Obtener la configuración de la sección correspondiente
        if($edicion=='false' || !$edicion){
            $elemento = Informes::obtenerConfiguracionSeccion("informes/tmp/config_temp.json",$id);
        }else{
            $elemento = Informes::obtenerConfiguracionSeccion("informes/{$id_informe}.json",$id);           
        }
        

        // Preparar columnas agrupadas por tabla
        $columnasPorTabla = [];

        if (isset($elemento["query"]["tablas_seleccionadas"])) {
            $tablasSeleccionadas = explode(',', $elemento["query"]["tablas_seleccionadas"]);

            foreach ($tablasSeleccionadas as $tabla) {
                $columnas = DatabaseService::obtenerColumnasDeTabla($tabla, ["updated_at", "created_at"]);
                $columnasPorTabla[$tabla] = $columnas;
            }
        }

        return view('sistema_cobros.informes.configuraciones.config_element_data',[
            "tablas"=>$tablas,
            "elemento"=>$elemento,
            "id"=>$id,
            "id_informe"=>$id_informe,
            "edicion"=>$edicion,
            "columnasPorTabla" => $columnasPorTabla,
        ]);
    }

    public function zonaJoinInformes(Request $request){
        $tablas = $request->input('tablas'); // ['tabla1', 'tabla2', 'tabla3']
        $paresDeTablas = [];
        $joins = $request->input('joins');   // <-- pueden venir del archivo json



        for ($i = 0; $i < count($tablas) - 1; $i++) {
            $paresDeTablas[] = [
                'a' => $tablas[$i],
                'b' => $tablas[$i + 1],
            ];
        }


        return view('sistema_cobros.informes.componentes.zona_join',["paresDeTablas"=>$paresDeTablas,  "tablasSeleccionadas" => $tablas]);
    }

    public function condicionWhereSimple(Request $request){
        $tablas = $request->input('tablas', []);
        $index = (int) $request->input("index", 0); // default 0
        $index_interno = $request->input("index_interno", 0); // ✅ correcto // default 0
        $esSubgrupo = $request->boolean('es_subgrupo', false); // true si está dentro de un where grupal
        $columnas = [];

        foreach ($tablas as $tabla) {
            $columnas[$tabla] = DatabaseService::obtenerColumnasDeTabla($tabla, ['id', 'created_at', 'updated_at']);
        }

        return view('sistema_cobros.informes.componentes.where_simple',["columnas"=>$columnas, "index" => $index,"index_interno"=>$index_interno,"esSubgrupo"=>$esSubgrupo]);
    }

    public function condicionWhereGrupal(Request $request){
         $index = (int) $request->input("index", 0);
        return view('sistema_cobros.informes.componentes.where_grupal',["index" => $index]);
    }

    public function camposFuncionAgregada(Request $request){
        $index = (int) $request->input("index", 0);
        $tablas = $request->input('tablas', []);
        $columnas = [];
        foreach ($tablas as $tabla) {
            $columnas[$tabla] = DatabaseService::obtenerColumnasDeTabla($tabla, ['id', 'created_at', 'updated_at']);
        }
     
        return view('sistema_cobros.informes.componentes.funcion_agregada',[
        "index" => $index,
        "columnas"=>$columnas,
        "valor_funcion" => '',
        "valor_columna" => '',
        "valor_alias" => '']);
    }

    public function eliminarSeccionInformes(Request $request){
        $id = $request->input('id');

        // 1. Cargar estructura JSON como arreglo asociativo
        $ruta = "informes/tmp/config_temp.json";
        $estructura = json_decode(Storage::get($ruta), true);

        // 2. Verificar si existe la clave 'secciones'
        if (!isset($estructura['secciones']) || !is_array($estructura['secciones'])) {
            return response()->json(['error' => 'Formato de archivo inválido.'], 400);
        }

        // 3. Filtrar las secciones para eliminar la que tenga ese ID
        $estructura['secciones'] = array_filter($estructura['secciones'], function ($seccion) use ($id) {
            return $seccion['id'] !== $id;
        });

        // 4. Reindexar el array (opcional)
        $estructura['secciones'] = array_values($estructura['secciones']);

        // 5. Guardar el archivo actualizado
        Storage::put($ruta, json_encode($estructura, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return response()->json(['success' => true]);
    }
}
