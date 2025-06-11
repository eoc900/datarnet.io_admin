<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inscripcion;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Mensajes;

class InscripcionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         if(Auth::user()->can('Ver inscripciones')){
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
      $registros = DB::table('inscripciones')
        ->select(
            'inscripciones.id',
            'inscripciones.periodo',
            DB::raw("CONCAT(users.name, ' ', users.lastname) as inscrito_por"),
            DB::raw("CONCAT(alumnos.nombre, ' ', alumnos.apellido_paterno, ' ', alumnos.apellido_materno) as alumno"),
        )
        ->join('alumnos', 'inscripciones.id_alumno', '=', 'alumnos.id')
        ->join('users', 'inscripciones.inscrito_por', '=', 'users.id')
        ->where(DB::raw("CONCAT(alumnos.nombre, ' ', alumnos.apellido_paterno, ' ', alumnos.apellido_materno)"), 'like', "%{$searchFor}%")
        ->orWhere('inscripciones.periodo', 'like', "%{$searchFor}%") // Cambié `=` a `like` para el patrón de búsqueda
        ->orWhere(DB::raw("CONCAT(users.name, ' ', users.lastname)"), 'like', "%{$searchFor}%");
        
        $tipos_contactos = [
            "title"=>"Inscripciones",
            "titulo_breadcrumb" => "Inscripciones",
            "subtitulo_breadcrumb" => "Inscripciones",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"inscripciones",
            "confTabla"=>array(
                "tituloTabla"=>"Inscripciones",
                "placeholder"=>"Buscar inscripciones",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"alumno","option"=>"Por alumno"],["key"=>"periodo","option"=>"Periodo"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array('periodo','alumno','inscrito_por'),
                "columns"=>array('Periodo',"Alumno","Inscrito Por"),
                "indicadores"=>false,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'inscripciones.destroy',
                "routeCreate" => ['inscripciones','create'],
                "routeEdit" => 'inscripciones.edit', // referente a un método ListadoFormularios
                "routeShow" => 'inscripciones.show',
                "routeIndex" => 'inscripciones.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Inscripciones"
            )];

            return view('sistema_cobros.inscripciones.index', $tipos_contactos);
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
        $inscripcion = new Inscripcion();
        return view('sistema_cobros.inscripciones.create',[
            "title"=>"Inscripciones",
            "titulo_breadcrumb" => "Inscripciones",
            "subtitulo_breadcrumb" => "Inscripciones",
            "tipos_inscripcion"=>$inscripcion->tipos_inscripcion,
            "modalidades"=>$inscripcion->modalidad
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validar los datos
        $validated = $request->validate([
            'id_alumno' => 'required|uuid|exists:alumnos,id',
            'cuatri' => 'required|array',
            'cuatri.*' => 'required|string|max:32',
            'anio' => 'required|array',
            'anio.*' => 'required|string|max:32',
            'tipo_inscripcion' => 'required|array',
            'tipo_inscripcion.*'=>'required|string|max:24'
        ]);



        foreach ($request->input('cuatri') as $index => $cuatri) {
            Inscripcion::create([
                'id' => (string) Str::uuid(),
                'id_alumno' => $request->id_alumno,
                'periodo' => $request->input('anio')[$index].''.$request->input('cuatri')[$index],
                'modalidad'=> $request->modalidad,
                'inscrito_por' => Auth::user()->id,
                'tipo_inscripcion'=>$request->input('tipo_inscripcion')[$index]
            ]);
        }

        return back()->with('success','Inscripcion registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inscripcion = DB::table('inscripciones')->where('inscripciones.id','=',$id)->first();
        return view('sistema_cobros.inscripciones.edit',[
            "title"=>"Inscripción",
            "breadcrumb_title" => "Inscripciones",
            "breadcrumb_second" => "Editar Inscripción",
            "inscripcion"=>$inscripcion,
            "anio"=> Str::substr($inscripcion->periodo, 0, 4),
            "cuatri"=>Str::substr($inscripcion->periodo, -1, 1)]);
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
        $record = Inscripcion::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'Inscripción eliminada con éxito.');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
    }
}
