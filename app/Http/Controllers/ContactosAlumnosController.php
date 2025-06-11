<?php

namespace App\Http\Controllers;

use App\Models\ContactoAlumno;
use App\Models\CorreoContactoAlumno;
use App\Models\TelefonoContactoAlumno;
use App\Models\DireccionContactoAlumno;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ContactosAlumnosController extends Controller
{
    // Mostrar lista de contactos de alumnos
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
        $registros = DB::table('contactos_alumnos')
        ->select('alumnos.matricula','contactos_alumnos.id','contactos_alumnos.activo',
        'CONCAT(alumnos.nombre," ",alumnos.apellido_paterno," ",alumnos.apellido_materno) as alumno',
        'tipos_contactos.tipo_contacto','CONCAT(contactos_alumnos.nombre," ",contactos_alumnos.apellido_paterno) as contacto')
        ->join('alumnos','alumnos.id','=','contactos_alumnos.id_alumno')
        ->where("alumnos.matricula","like","%{$searchFor}%")
        ->where(DB::raw('CONCAT(alumnos.nombre," ",alumnos.apellido_paterno," ",alumnos.apellido_materno)'),'like',"%{$searchFor}%")
        ->where(DB::raw('CONCAT(contactos_alumnos.nombre," ",contactos_alumnos.apellido_paterno," ",contactos_alumnos.apellido_materno)'),'like',"%{$searchFor}%");
        $contactos = [
            "title"=>"Lista de contactos",
            "titulo_breadcrumb" => "Contactos de Alumnos",
            "subtitulo_breadcrumb" => "Contactos",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"tipos_correos",
            "confTabla"=>array(
                "tituloTabla"=>"Mis tipos de correo",
                "placeholder"=>"Buscar tipos de correos",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"nombre_alumno","option"=>"Nombre de Alumno"],["key"=>"nombre_contacto","option"=>"Nombre de Contacto"],
                ["key"=>"matricula","option"=>"Matrícula"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array('matricula','alumno','contacto','activo'),
                "columns"=>array("Matrícula","Alumno","Nombre Contacto","Activo"),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'contactos_alumnos.destroy',
                "routeCreate" => ['formulario','alta_escuelas'],
                "routeEdit" => 'contactos_alumnos.edit', // referente a un método ListadoFormularios
                "routeShow" => 'contactos_alumnos.show',
                "routeIndex" => 'contactos_alumnos.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Contacto"
            )
            

        ];
        return view('sistema_cobros.contactos_alumnos.index', $contactos);
    }

    // Mostrar un contacto específico
    public function show($id)
    {
        // Obtener el contacto por su ID
        $contacto = DB::table('contactos_alumnos')->select('alumnos.matricula','contactos_alumnos.id','contactos_alumnos.activo',
        DB::raw('CONCAT(alumnos.nombre," ",alumnos.apellido_paterno," ",alumnos.apellido_materno) as alumno'),
        'tipos_contactos.tipo_contacto',DB::raw('CONCAT(contactos_alumnos.nombre," ",contactos_alumnos.apellido_paterno) as contacto'))
        ->join('alumnos','alumnos.id','=','contactos_alumnos.id_alumno')
        ->where('contactos_alumnos.id', $id)  // Filtramos por el id
        ->first();  // Obtener el primer resultado

        //Correos
        $correos = DB::table('correos_contactos_alumnos')
        ->select(
            'correos_contactos_alumnos.correo',
            'correos_contactos_alumnos.id',
            'correos_contactos_alumnos.activo',
            'tipos_correos_contactos_alumnos.tipo_correo',
            DB::raw('CONCAT(contactos_alumnos.nombre, " ", contactos_alumnos.apellido_paterno) as contacto')
        )
        ->join('contactos_alumnos', 'contactos_alumnos.id', '=', 'correos_contactos_alumnos.id_contacto')
        ->join('tipos_correos_contactos_alumnos', 'tipos_correos_contactos_alumnos.id', '=', 'correos_contactos_alumnos.id_tipo_correo')
        ->where('correos_contactos_alumnos.activo', true)
        ->where('contactos_alumnos.id','=',$id)
        ->get();

        $telefonos = $telefonos = DB::table('telefonos_contactos_alumnos')
        ->select(
            'telefonos_contactos_alumnos.telefono',
            'telefonos_contactos_alumnos.id',
            'telefonos_contactos_alumnos.activo',
            DB::raw('CONCAT(contactos_alumnos.nombre, " ", contactos_alumnos.apellido_paterno) as contacto')
        )
        ->join('contactos_alumnos', 'contactos_alumnos.id', '=', 'telefonos_contactos_alumnos.id_contacto')
        ->where('telefonos_contactos_alumnos.activo', true)  // Filtrar solo los teléfonos activos
        ->where('contactos_alumnos.id','=',$id)
        ->get();

        $direcciones = DB::table('direcciones_contactos_alumnos')
        ->select(
            'direcciones_contactos_alumnos.calle',
            'direcciones_contactos_alumnos.num_exterior',
            'direcciones_contactos_alumnos.num_interior',
            'direcciones_contactos_alumnos.colonia',
            'direcciones_contactos_alumnos.codigo_postal',
            'direcciones_contactos_alumnos.id',
            'direcciones_contactos_alumnos.activo',
            DB::raw('CONCAT(contactos_alumnos.nombre, " ", contactos_alumnos.apellido_paterno) as contacto')
        )
        ->join('contactos_alumnos', 'contactos_alumnos.id', '=', 'direcciones_contactos_alumnos.id_contacto')
        ->where('direcciones_contactos_alumnos.activo', true) 
        ->where('contactos_alumnos.id','=',$id) // Filtrar solo las direcciones activas
        ->get();


        if (!$contacto) {
            return response()->json(['error' => 'Contacto no encontrado'], 404);
        }

        return view('sistema_cobros.contactos_alumnos.show',[
            "title"=>"Alta de tipos de correo",
            "titulo_breadcrumb" => "Tipos de Correo",
            "contacto"=>$contacto,
            "correos"=>$correos,
            "telefonos"=>$telefonos,
            "direcciones"=>$direcciones]);
    }

    // Crear un nuevo contacto
    public function create(){
        $tipos_contactos = DB::table('tipos_contactos')->get();
        $tipos_correos = DB::table('tipos_correos_contactos_alumnos')->get();
        return view('sistema_cobros.contactos_alumnos.create',["title"=>"Lista de contactos",
            "titulo_breadcrumb" => "Contactos de Alumnos",
            "tipos_contactos"=>$tipos_contactos,
            "tipos_correos"=>$tipos_correos]);
    }


    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'id_alumno' => 'required|uuid',
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'tipo_contacto' => 'required',  // Debe ser un array 
            'correo' => 'required|array',  // Debe ser un array
            'correo.*' => 'required|email|max:32',  // Cada entrada de correo debe ser válida
            'tipo_correo_contacto' => 'required|array',  // Debe ser un array
            'tipo_correo_contacto.*' => 'required',  // Cada tipo de correo debe ser un UUID
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

        if (count($request->input('correo')) !== count($request->input('tipo_correo_contacto'))) {
            return back()->with('error','El número de correos no coincide.');
        }

        // Comprobar si la validación falla
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $id_contacto = (string) Str::uuid();

        $contacto = new ContactoAlumno([
            'id'=>$id_contacto,
            'id_alumno' => $request->id_alumno,
            'id_tipo_contacto'=>$request->tipo_contacto,
            'nombre'=>$request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'activo' => false
        ]);
        $contacto->save();

        foreach ($request->input('correo') as $index => $correo) {
            CorreoContactoAlumno::create([
                'id_contacto' => $id_contacto,
                'correo' => $correo,
                'id_tipo_correo' => $request->input('tipo_correo_contacto')[$index],
                'pin_acceso'=> Str::random(6, '0123456789'),
                'confirmado' => false, 
                'activo' =>  false  // Puedes ajustar este valor según sea necesario
            ]);
        }

         foreach ($request->input('telefono') as $index => $telefono) {
            TelefonoContactoAlumno::create([
                'id_contacto' => $id_contacto,
                'telefono' => $telefono,
                'activo' => true  // Puedes ajustar este valor según sea necesario
            ]);
        }

        foreach ($request->input('calle') as $index => $calle) {
            // Creamos un nuevo registro de dirección para cada conjunto de datos
            DireccionContactoAlumno::create([
                'id_contacto' => $id_contacto, // Asegúrate de que este dato venga en el request
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

        return back()->with('success','Se agregaron los datos exitosamente.');
    }

    

    // Actualizar un contacto existente
    public function update(Request $request, $id)
    {
        // Validar los datos del request
        $validator = Validator::make($request->all(), [
            'id_alumno' => 'required|uuid',
            'id_tipo_contacto' => 'required|uuid',
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'activo' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Buscar el contacto existente
        $contacto = ContactoAlumno::find($id);

        if (!$contacto) {
            return response()->json(['error' => 'Contacto no encontrado'], 404);
        }

        // Actualizar los datos del contacto
        $contacto->update($request->all());

        return response()->json($contacto);
    }

    // Eliminar un contacto
    public function destroy($id)
    {
        // Buscar el contacto existente
        $contacto = ContactoAlumno::find($id);

        if (!$contacto) {
            return response()->json(['error' => 'Contacto no encontrado'], 404);
        }

        // Eliminar el contacto
        $contacto->delete();

        return response()->json(['message' => 'Contacto eliminado con éxito']);
    }
}
