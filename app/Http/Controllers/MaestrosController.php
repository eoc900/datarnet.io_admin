<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMaestroRequest;
use App\Http\Requests\UpdateMaestroRequest;
use App\Models\TipoCorreoMaestro;
use App\Models\Maestro;
use App\Models\Materia;
use App\Models\CapacidadMateriasMaestro;
use App\Models\TelefonoMaestro;
use App\Models\CorreoMaestro;
use App\Models\DireccionMaestro;
use App\Models\Escuela;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;


class MaestrosController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         if(Auth::user()->can('Ver maestros')){
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
      $registros = DB::table('maestros')
        ->select(
            'maestros.id',
            'maestros.activo',
            DB::raw("CONCAT(users.name, ' ', users.lastname) as creadoPor"),
            DB::raw("CONCAT(maestros.nombre, ' ', maestros.apellido_paterno, ' ', maestros.apellido_materno) as maestro"),
        )
        ->join('users', 'maestros.creadoPor', '=', 'users.id')
        ->where(DB::raw("CONCAT(maestros.nombre, ' ', maestros.apellido_paterno, ' ', maestros.apellido_materno)"), 'like', "%{$searchFor}%")
        ->orWhere('maestros.activo', 'like', "%{$searchFor}%"); // Cambié `=` a `like` para el patrón de búsqueda
       
        
        $tipos_contactos = [
            "title"=>"Maestros",
            "titulo_breadcrumb" => "Maestros",
            "subtitulo_breadcrumb" => "Maestros",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"maestros",
            "confTabla"=>array(
                "tituloTabla"=>"Maestros",
                "placeholder"=>"Buscar maestros",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"alumno","option"=>"Por alumno"],["key"=>"periodo","option"=>"Periodo"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array('maestro','creadoPor','activo'),
                "columns"=>array('Maestro',"Registrado por","Activo"),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'maestros.destroy',
                "routeCreate" => ['maestros','create'],
                "routeEdit" => 'maestros.edit', // referente a un método ListadoFormularios
                "routeShow" => 'maestros.show',
                "routeIndex" => 'maestros.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Maestros"
            )];

            return view('sistema_cobros.maestros.index', $tipos_contactos);
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
        $tipos_correos = TipoCorreoMaestro::all();
        $escuelas = Escuela::all();
        return view('sistema_cobros.maestros.create',[
            "title"=>"Maestros",
            "titulo_breadcrumb" => "Maestros",
            "subtitulo_breadcrumb" => "Maestros",
            "tipos_correos"=>$tipos_correos,
            "escuelas"=>$escuelas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:32',
            'apellido_paterno' => 'required|string|max:32',
            'apellido_materno' => 'required|string|max:32',
            'matricula' => 'required|string|max:8',
            'id_escuela'=>  'required|uuid|exists:escuelas,id',
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
            'estado.*' => 'required|string|max:24'
        ]);



        if (count($request->input('correo')) !== count($request->input('tipo_correo'))) {
            return back()->with('error','El número de correos no coincide.');
        }


        $maestro = new Maestro([
            'matricula'=>$request->matricula,
            'nombre'=>$request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'activo' => false,
            'creadoPor' => Auth::user()->id,
            'id_escuela' => $request->id_escuela
        ]);
        // Guardar la instancia en la base de datos
        $maestro->save();

         foreach ($request->input('correo') as $index => $correo) {
            CorreoMaestro::create([
                'id'=>(string) Str::uuid(),
                'id_maestro' => $maestro->id,
                'correo' => $correo,
                'id_tipo_correo' => $request->input('tipo_correo')[$index],
                'creadoPor' => Auth::user()->id, 
                'activo' =>  false  // Puedes ajustar este valor según sea necesario
            ]);
        }

        foreach ($request->input('telefono') as $index => $telefono) {
            TelefonoMaestro::create([
                'id_maestro' => $maestro->id,
                'telefono' => $telefono,
                'creadoPor' => Auth::user()->id, 
                'activo' =>  true  // Puedes ajustar este valor según sea necesario
            ]);
        }

        foreach ($request->input('calle') as $index => $calle) {
            // Creamos un nuevo registro de dirección para cada conjunto de datos
            DireccionMaestro::create([
                'id_maestro' => $maestro->id, // Asegúrate de que este dato venga en el request
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

        return back()->with('success','Datos del maestro registrados exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function materiasQuePuedeDar(string $maestro = ""){

        $capaz = "";
        $materias_maestro = [];
        if($maestro!=""){
                $materias_maestro = Maestro::where("id", $maestro)
                ->first()
                ?->capacidadMaterias()->pluck('id_materia')->toArray() ?? ""; 
                $maestro = Maestro::where("id", $maestro)->first();
               
        }

        $materias_preparatoria = DB::table("materias")
        ->select("materias.id","materias.materia","sistemas_academicos.nivel_academico")
        ->join("sistemas_academicos","materias.id_sistema","=","sistemas_academicos.id")
        ->where("sistemas_academicos.nivel_academico","like","%Preparatoria%")
        ->get();
        return view("sistema_cobros.maestros.definir_materias",
        ["title"=>"Lista materias",
        "maestro"=>$maestro,
        "maestro_materias"=>$materias_maestro,
        "materias"=>$materias_preparatoria]);
    }

    public function guardarMateriasDefinidas(Request $request){
        $request->validate([
            "maestro"=>"string|exists:maestros,id",
            'materia' => 'required|array',
            'materia.*' => 'required|string|max:36|exists:materias,id',
        ]);

        $materiasNuevas = $request->input('materia', []);
        // Obtener las materias actuales del maestro
        $materiasActuales = DB::table('capacidad_materias_maestros')
            ->where('id_maestro', $request->maestro)
            ->pluck('id_materia')
            ->toArray();

        // Determinar materias a insertar
        $materiasAInsertar = array_diff($materiasNuevas, $materiasActuales);

        // Determinar materias a eliminar
        $materiasAEliminar = array_diff($materiasActuales, $materiasNuevas);

        // Insertar las materias faltantes
        foreach ($materiasAInsertar as $materia) {
            DB::table('capacidad_materias_maestros')->insert([
                'id_maestro' => $request->maestro,
                'id_materia' => $materia,
                'activo'=>1,
                'creadoPor'=> Auth::user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Eliminar las materias sobrantes
        if (!empty($materiasAEliminar)) {
            DB::table('capacidad_materias_maestros')
                ->where('id_maestro', $request->maestro)
                ->whereIn('id_materia', $materiasAEliminar)
                ->delete();
        }

         

        return back()->with("Success","Se actualizaron las materias");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maestro = DB::table('maestros')->where('maestros.id','=',$id)->first();
        $telefonos = DB::table('telefonos_maestros')->where('id_maestro','=',$id)->get();

        $correos = DB::table('correos_maestros')
        ->select('correos_maestros.correo','tipos_correos_maestros.id','tipos_correos_maestros.tipo_correo')
        ->join('tipos_correos_maestros','correos_maestros.id_tipo_correo','=','tipos_correos_maestros.id')
        ->where('correos_maestros.id_maestro','=',$id)
        ->get();
        $direcciones = DB::table('direcciones_maestros')->where('id_maestro','=',$id)->get();
        $escuelas = DB::table('escuelas')->get();
        

        return view('sistema_cobros.maestros.edit',[
            "title"=>"Maestro",
            "breadcrumb_title" => "Maestros",
            "breadcrumb_second" => "Editar maestro",
            "maestro"=>$maestro,
            "telefonos"=>$telefonos,
            "correos"=>$correos,
            "direcciones"=>$direcciones,
            "escuelas"=>$escuelas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mensajes = new Mensajes(); // registro de respuestas add(["mensaje"=>"Almacenamiento de acta de nacimiento exitosa","respuesta"=>true])
        $ins = Inscripcion::findOrFail($id);

     
        $ins->update([
        'periodo'=>$request->anio."".$request->cuatri,
        'modalidad'=>$request->modalidad
        ]);
       
        $mensajes->add(array("response"=>true,"message"=>"Se editó el registro de inscripción"));

       return back()->with('mensajes',$mensajes->log);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Maestro::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'Maestro eliminado con éxito.');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
    }
}
