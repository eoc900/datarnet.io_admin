<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTareasRequest;
use App\Http\Requests\UpdateTareasRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Tareas;
use App\Models\User;
use App\Models\TareasAsignadas;

class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchFor = "";
        $filter = "";
        $page = 1;
        if($request->search != "" && isset($request->search)){
            $searchFor = $request->search;
        }
        if($request->page != "" && isset($request->page)){
            $page = $request->page;
        }

        $tareas = Tareas::busquedaPorEstado($filter);

        //Filtros
        if($request->filter != "" && isset($request->filter)){
            $filter = $request->filter;
            if($filter=="nombre responsable"){
                 $tareas = Tareas::busquedaPorResponsable($searchFor);
            }

            if($filter=="estado"){
                 $tareas = Tareas::busquedaPorEstado($searchFor);
            }

            if($filter=="titulo"){
                 $tareas = Tareas::busquedaPorTitulo($searchFor);
            }
        }
        
        $t = new Tareas();
        $estados = $t->estados;
        $count = $tareas->count();
        $tareas = $tareas->paginate(10);
        $tareas->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]);
         return view('administrador.tareas.index',[
            "title"=>"Tareas",
            "breadcrumb_title" => "Tareas",
            "breadcrumb_second" => "Visualizar lista",
            "hasDynamicTable"=>true,
            "rowCheckbox"=>true,
            "idKeyName"=>"id",
            "keys"=>array('id',"titulo",'name',"responsable","estado"),
            "columns"=>array("#Ref","Titulo","Creada Por","Asignada","Estado"),
            "indicadores"=>true,
            "botones"=>array('Pendiente'=>'btn-outline-danger',
                                'En Progreso'=>'btn-outline-primary',
                                'Completada'=>'btn-outline-success',
                                'Aprobada'=>'btn-outline-info',
                                'Reformular'=>'btn-outline-warning'),
            "rowActions"=>array("show","edit","destroy"),
            "data" => $tareas,
            "routeDestroy" => 'tareas.destroy',
            "routeCreate" => 'tareas.create',
            "routeEdit" => 'tareas.edit',
            "routeShow" => 'tareas.show',
            "routeIndex" => 'tareas.index',
            "ajaxRenderRoute" => '/html/tabletareas',
            "reRenderSection" => ".dynamic_table",
            "searchFor"=>$searchFor,
            "count" => $count,
            "filtros_busqueda"=>["Nombre responsable","Titulo","Estado"],
            "txtBtnCrear"=>"Agregar una tarea"
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $tareas = new Tareas();
        $estados = $tareas->estados;
        $usuarios = User::select('id','name','lastname')->get();
        return view('administrador.tareas.create',[
            "title"=>"Tareas",
            "breadcrumb_title" => "Tareas",
            "breadcrumb_second" => "Visualizar tareas",
            "estados" => $estados,
            "usuarios" => $usuarios,
            "routeDestroy" => 'tareas.destroy',
            "routeCreate" => 'tareas.create',
            "routeEdit" => 'tareas.edit',
            "routeShow" => 'tareas.show',
            "routeIndex" => 'tareas.index'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTareasRequest $request)
    {
        $ref = Str::random(40);
        $tareas = new Tareas();
        $tareas->titulo = $request->titulo;
        $tareas->referencia = $ref;
        $tareas->descripcion = $request->descripcion;
        $tareas->creada_por = Auth::user()->id; // Asumiendo que tienes autenticación y quieres guardar el nombre del usuario
        $tareas->actualizada_por = Auth::user()->id; // Asumiendo que tienes autenticación y quieres guardar el nombre del usuario
        $tareas->fecha_inicio = $request->fecha_inicio;
        $tareas->terminar_en = $request->terminar_en;
        $tareas->estado = $request->estado;
        $tareas->created_at = now();

        // Guardar el registro en la base de datos
        $tareas->save();

        $tareasAsignadas = new TareasAsignadas();
        $tareasAsignadas->ref = $ref;
        $tareasAsignadas->id_usuario = $request->responsable;

        $tareasAsignadas->save();
        return redirect()->route('tareas.index')->with('success', 'Tarea agregada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tarea = new Tareas();
        $estados = $tarea->estados;
        $usuarios = User::select('id','name','lastname')->get();
        $tareas = Tareas::where('id', '=', $id)->firstOrFail(); 
        return view('administrador.tareas.show',[
            "title"=>"Tareas",
            "breadcrumb_title" => "Tareas",
            "breadcrumb_second" => "Visualizar tareas",
            "estados" => $estados,
            "usuarios" => $usuarios,
            "tarea"=>$tareas
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tareas = new Tareas();
        $estados = $tareas->estados;
         $tarea = Tareas::where('id','=',$id)->firstOrFail();
         return view('administrador.tareas.edit',[
            "title"=>"Tareas",
            "breadcrumb_title" => "Tareas",
            "breadcrumb_second" => "Visualizar tareas",
            "estados" => $estados,
            "tarea" => $tarea,
            "routeDestroy" => 'tareas.destroy',
            "routeCreate" => 'tareas.create',
            "routeEdit" => 'tareas.edit',
            "routeShow" => 'tareas.show',
            "routeIndex" => 'tareas.index',
            
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tareas = Tareas::findOrFail($id);

        if($tareas->creada_por == Auth::user()->id){
             $tareas->update([
                'terminar_en' => $request->input('terminar_en'),
                'estado' => $request->input('estado'),
                'updated_at' => now(),
                'actualizada_por' => Auth::user()->id
            ]);
            return back()->with('success', 'La tarea fue actualizada.');
        }
        return back()->with('error', 'Solamente el usuario que creó la tarea puede modificarla.');

       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = Tareas::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'Tarea fue eliminada exitosamente.');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
    }
}
