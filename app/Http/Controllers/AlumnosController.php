<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Mensajes;
use App\Models\Alumno;
use App\Models\Cuenta;
use App\Helpers\PagosDiferidos;
use App\Models\CorreoAsociado;
use App\Models\TelefonoAlumno;
use App\Models\DireccionAlumno;
use Illuminate\Support\Facades\DB;
use App\Models\EnvioConfirmacion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Email;

class AlumnosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(Auth::user()->can('Ver alumnos')){
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
         $registros = DB::table('alumnos')
                    ->select("sistemas_academicos.codigo_sistema","alumnos.matricula",
                    DB::raw('CONCAT(alumnos.nombre," ",alumnos.apellido_paterno," ",alumnos.apellido_materno) as alumno'),
                    "alumnos.id","alumnos.activo")
                    ->join('sistemas_academicos','alumnos.id_sistema_academico',"=",'sistemas_academicos.id')
                    ->where(DB::raw("CONCAT(alumnos.nombre, ' ',alumnos.apellido_paterno,' ',alumnos.apellido_materno)"), 'like', "%{$searchFor}%");
         $alumnos = [
                        "title"=>"Alumnos",
                        "titulo_breadcrumb" => "Alumnos",
                        "subtitulo_breadcrumb" => "Visualizar Alumnos",
                        "go_back_link"=>"#",
                        "formulario"=>"alumnos", // se utiliza para el form tag
                        "tabla"=>"tabla.alumnos",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"/alumnos",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis Alumnos",
                            "placeholder"=>"Buscar alumno",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"alumno","option"=>"Nombre completo"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("matricula","codigo_sistema","alumno","activo"),
                            "columns"=>array("Matrícula","Código Sistema","Alumno","Estado"),
                            "indicadores"=>true,
                            "botones"=>array('0'=>'btn-outline-danger',
                                                '1'=>'btn-outline-success'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(10)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'alumnos.destroy',
                            "routeCreate" => ['formulario','alta_alumnos'],
                            "routeEdit" => 'alumnos.edit',
                            "routeShow" => 'alumnos.show',
                            "routeIndex" => 'tabla',
                            "ajaxRenderRoute" => '/html/tabletareas',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar una tarea"
                        )
                        

                    ];
          
        return view('sistema_cobros.alumnos.index', $alumnos);
        }

        return view('sistema_cobros.respuestas_peticiones.no_tienes_acceso', [
            "title"=>"Sin acceso",
            "titulo_breadcrumb" => "Lo sentimos"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->can('Agregar alumno')){
       $sistemas = DB::table('sistemas_academicos')
       ->select('sistemas_academicos.id',DB::raw('CONCAT("Sistema: ",sistemas_academicos.codigo_sistema,", Escuela: ",escuelas.codigo_escuela) as codigo_sistema'))
       ->join('escuelas','sistemas_academicos.id_escuela','=','escuelas.id')
       ->get();

       $tipos_correos = DB::table('tipos_correos_alumnos')->get();
          return view('sistema_cobros.alumnos.create',[
            "title"=>"Alta de tipos de correos de contactos",
            "titulo_breadcrumb" => "Tipos de correo de contactos",
            "sistemas_academicos"=>$sistemas,
            "tipos_correos"=>$tipos_correos]);
            
        }
        
        return view('sistema_cobros.respuestas_peticiones.no_tienes_acceso', [
            "title"=>"Sin acceso",
            "titulo_breadcrumb" => "Lo sentimos"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('Agregar alumno')){
          // Validar los datos entrantes
        $enviado = false;
        $validator = Validator::make($request->all(), [
            'matricula' => 'required|string|max:10|unique:alumnos,matricula',
            'id_sistema' => 'required|uuid',
            'nombre' => 'required|string|max:32',
            'apellido_paterno' => 'required|string|max:32',
            'apellido_materno' => 'required|string|max:32',
            // Validación para correos
            'correo' => 'required|array',  // Debe ser un array
            'correo.*' => 'required|email|max:32',  // Cada entrada de correo debe ser válida
            'tipo_correo' => 'required|array',  // Debe ser un array
            'tipo_correo.*' => 'required',  // Cada tipo de correo debe ser un UUID
            'telefono' => 'required|array',  // Debe ser un array
            'telefono.*' => 'required',  // Cada tipo de correo debe ser un UUID
            'calle' => 'required|array',
            'calle.*' => 'required|string|max:32',
            'num_exterior' => 'required|array',
            'num_exterior.*' => 'required|string|max:7',
            'num_interior' => 'nullable|array',
            'num_interior.*' => 'nullable|string|max:7',
            'colonia' => 'required|array',
            'colonia.*' => 'required|string|max:32',
            'codigo_postal' => 'required|array',
            'codigo_postal.*' => 'required|string|max:7',
            'ciudad' => 'required|array',
            'ciudad.*' => 'required|string|max:32',
            'estado' => 'required|array',
            'estado.*' => 'required|string|max:24',
        ]);


        if (count($request->input('correo')) !== count($request->input('tipo_correo'))) {
            return back()->with('error','El número de correos no coincide.');
        }

        // Comprobar si la validación falla
        if ($validator->fails()) {
            return back()->with('error','Hubo un error al insertar los datos del alumno.');
        }
        $id_alumno = (string) Str::uuid();
        $alumno = new Alumno([
            'id' => $id_alumno, // Generar un UUID
            'matricula'=>$request->matricula,
            'id_sistema_academico'=>$request->id_sistema,
            'nombre'=>$request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'activo' => false,
            'creado_por' => Auth::user()->id,
        ]);
        // Guardar la instancia en la base de datos
        $alumno->save();

        foreach ($request->input('correo') as $index => $correo) {
            CorreoAsociado::create([
                'id'=>(string) Str::uuid(),
                'id_alumno' => $alumno->id,
                'correo' => $correo,
                'tipo_correo' => $request->input('tipo_correo')[$index],
                'createdBy' => Auth::user()->id, 
                'activo' =>  false  // Puedes ajustar este valor según sea necesario
            ]);
        }

        foreach ($request->input('telefono') as $index => $telefono) {
            TelefonoAlumno::create([
                'id'=>(string) Str::uuid(),
                'id_contacto' => $alumno->id,
                'telefono' => $telefono,
                'activo' => true  // Puedes ajustar este valor según sea necesario
            ]);
        }

        foreach ($request->input('calle') as $index => $calle) {
            // Creamos un nuevo registro de dirección para cada conjunto de datos
            DireccionAlumno::create([
                'id_alumno' => $id_alumno, // Asegúrate de que este dato venga en el request
                'calle' => $calle,
                'num_exterior' => $request->input('num_exterior')[$index],
                'num_interior' => $request->input('num_interior')[$index] ?? null,
                'colonia' => $request->input('colonia')[$index],
                'codigo_postal' => $request->input('codigo_postal')[$index],
                'ciudad' => $request->input('ciudad')[$index],
                'estado' => $request->input('estado')[$index],
                'activo' => true, // Puedes ajustar esto según tu lógica
            ]);

        }

        // Obtener el correo asignado para ccuenta
        $correo = DB::table('correos_asociados')->select('correos_asociados.correo','tipos_correos_alumnos.tipo_correo')
        ->join('tipos_correos_alumnos','tipos_correos_alumnos.id','=','correos_asociados.tipo_correo')
        ->where('correos_asociados.id_alumno','=',$id_alumno)
        ->where('tipos_correos_alumnos.tipo_correo','like','%ccuenta%')
        ->first();

        $correo = $correo->correo;

        // 1. Insertar codigo de confirmación 
         // Crear el nuevo registro
        $codigo_url = (string) Str::uuid(); 
        $registro = EnvioConfirmacion::create([
            'id' => Str::uuid(), // Genera un UUID para el campo 'id'
            'id_alumno' => $id_alumno,
            'entregado' => false,
            'confirmado' => false,
            'verificado_presencial' => false,
            'codigo_36' => $codigo_url
        ]);

        // 2. Enviar la url al correo del alumno correspondiente a ccuenta
        if(isset($request->prueba) && $request->prueba==true){
        $email = new Email();
        $titulo = "Te damos la bienvenida ";
        $html_mensaje = '<h1>Falta poco</h1>';
        $html_mensaje .= '<h3>!'.$request->nombre.' estas a unos cuantos pasos de completar tu proceso de inscripción!</h3><br>';
        $html_mensaje .= '<p>Por favor da click en el siguiente enlace, para crear tu <b>CCuenta:</b></p>';
        $html_mensaje .= '<a href="https://cegto.com.mx/enlazar/'.$codigo_url.'" style="border: 1px solid green; border-radius:10px; color:white;"> Registrar CCuenta </a>';
        $enviado = $email->sendEmail($titulo,$html_mensaje,"",$correo,$request->nombre." ".$request->apellido_paterno);

        
        // 3. Cambiar el estatus de enviado/entregado
        if($enviado){
            $registro->update([
                'entregado' => true
            ]);
        }
        }

        //return back()->with('success','Se insertó al alumno exitosamente.');
        return to_route('post_create.alumnos', ['id' => $id_alumno,'enviado' => $enviado]);
        }

        // En caso de no tener el permiso
        return back()->with('error','Lo sentimos no tienes autorizado hacer esta petición');
    }

    public function postCreate(Request $request){
        $alumno = DB::table('alumnos')->select('alumnos.id as id_alumno',DB::raw('CONCAT(alumnos.nombre," ",alumnos.apellido_paterno," ",alumnos.apellido_materno) as alumno'))
        ->where('alumnos.id', $request->id)->first();
        return view('sistema_cobros.alumnos.post_create',[
            'title'=>"Alumno",
            'subtitulo_breadcrumb'=>"",
            'titulo_breadcrumb'=>"",
            "alumno"=>$alumno,
            'id'=>$request->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id=null)
    {
        if(Auth::user()->can('Ver alumno')){
        $alumnos = Alumno::informacionBasica($id);
        $cuentas = Cuenta::cuentasAlumno($id);


        $correoCCuenta = DB::table('correos_asociados')
        ->select('correos_asociados.correo as ccuenta','tipos_correos_alumnos.tipo_correo','correos_asociados.activo')
        ->join('tipos_correos_alumnos','tipos_correos_alumnos.id','=','correos_asociados.tipo_correo')
        ->where('tipos_correos_alumnos.tipo_correo','like','%ccuenta%')
        ->where('correos_asociados.id_alumno','=',$id)
        ->first();
        return view('sistema_cobros.alumnos.show',[
            'title'=>"Alumno",
            'subtitulo_breadcrumb'=>"",
            'titulo_breadcrumb'=>"",
            'alumno'=>$alumnos,
            'cuentas'=>$cuentas,
            'avatar'=>null,
            'fechasPeriodo'=>PagosDiferidos::getCuatrimestreFechas(date('Y'), PagosDiferidos::cuatrimestreActual(),false),
            'renderSectionID'=>'cobros_tabla',
            'routeAjaxName'=>'/ajax/tabla_cobros',
            'ajaxCallSuffix'=>'cobros',
            'classOnChange'=>'id_cuentas',
            'ccuenta'=>$correoCCuenta
        ]);
        }
        return view('sistema_cobros.respuestas_peticiones.no_tienes_acceso', [
            "title"=>"Sin acceso",
            "titulo_breadcrumb" => "Lo sentimos"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->can('Editar alumno')){
        $alumno = DB::table('alumnos')->where('alumnos.id','=',$id)->first();
        $sistemas = DB::table('sistemas_academicos')->get();
        return view('sistema_cobros.alumnos.edit',[
            "title"=>"Usuario",
            "breadcrumb_title" => "Usuario",
            "breadcrumb_second" => "Editar Usuario",
            "alumno"=>$alumno,
            "sistemas_academicos"=>$sistemas]);
        }
        return view('sistema_cobros.respuestas_peticiones.no_tienes_acceso', [
            "title"=>"Sin acceso",
            "titulo_breadcrumb" => "Lo sentimos"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->can('Editar alumno')){
        $mensajes = new Mensajes(); // registro de respuestas add(["mensaje"=>"Almacenamiento de acta de nacimiento exitosa","respuesta"=>true])
        $alumno = Alumno::findOrFail($id);

     
        $alumno->update([
        'id_sistema_academico'=>$request->sistema_academico,
        'nombre' => $request->nombre,
        'matricula' => $request->matricula,
        'apellido_paterno' => $request->apellido_paterno,
        'apellido_materno' => $request->apellido_materno,
        'creadoPor'=>Auth::user()->id,
        'activo' => $request->activo,
        ]);
        $mensajes->add(array("response"=>true,"message"=>"Se editó el registro de alumno"));

        return back()->with('mensajes',$mensajes->log);
        }
        return back()->with('error', 'No cuentas con el permiso para editar alumnos.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->can('Eliminar alumno')){
            $record = Alumno::find($id);
            if($record){
                $record->delete();
                return back()->with('success', 'Alumno eliminado con éxito.');
            }
            return back()->with('error', 'Hubo un error al tratar de borrar registro');
        }
         return back()->with('error', 'No cuentas con el permiso para eliminar alumnos.');
    }
}
