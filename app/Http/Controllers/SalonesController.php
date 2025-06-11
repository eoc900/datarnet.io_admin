<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escuela;
use App\Models\Salon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalonesController extends Controller
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
        if($request->filter != "" && isset($request->filter)){
            $filter = $request->filter;
        }
        if($request->page != "" && isset($request->page)){
            $page = $request->page;
        }
         $registros = DB::table("salones")
         ->select("salones.id","salones.nombre","salones.activo","salones.capacidad","escuelas.nombre as escuela")
         ->join("escuelas","salones.id_escuela","=","escuelas.id")
         ->where("salones.nombre","like","%{$searchFor}%")
         ->orWhere("escuelas.nombre","like","%{$searchFor}%")
         ->orWhere("escuelas.codigo_escuela","like","%{$searchFor}%")
         ->orWhere("salones.capacidad","<=",$searchFor);
                    $salones = [
                        "title"=>"Salones",
                        "titulo_breadcrumb" => "Salones",
                        "subtitulo_breadcrumb" => "Salones",
                        "go_back_link"=>"#",
                        "formulario"=>"salones", // se utiliza para el form tag
                        "tabla"=>"tabla.sistemas_academicos",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"salones",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis salones",
                            "placeholder"=>"Buscar salones",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"clave_escuela","option"=>"Clave escuela"],
                            ["key"=>"salon","option"=>"Nombre salón"],
                            ["key"=>"escuela","option"=>"Nombre de escuela"],
                            ["key"=>"capacidad","option"=>"Capacidad de alumnos"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("nombre",'escuela','capacidad',"activo"),
                            "columns"=>array("Salón","Escuela","Capacidad","Activo"),
                            "indicadores"=>true,
                            "numerico"=>true,
                            "botones"=>array('0'=>'btn-outline-danger',
                                                '1'=>'btn-outline-success'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'salones.destroy',
                            "routeCreate" => "salones.create",
                            "routeEdit" => 'salones.edit',
                            "routeShow" => 'salones.show',
                            "routeIndex" => 'tabla',
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar un salón"
                        )
                        

                    ];
            return view('sistema_cobros.salones.index', $salones); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $escuelas = Escuela::all();
        return view("sistema_cobros.salones.create",[
            "title"=>"Crear un salón",
            "escuelas"=>$escuelas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre"=>"required|string|max:32",
            "capacidad"=>"required|integer|max:100",
            "activo"=>"required|boolean",
            "id_escuela"=>"required|uuid|exists:escuelas,id"]);
        
        $salon = new Salon();
        $salon->nombre = $request->nombre;
        $salon->capacidad = $request->capacidad;
        $salon->id_escuela = $request->id_escuela;
        $salon->activo = $request->activo;
        $salon->creadoPor = Auth::user()->id;
        $salon->save();

        return back()->with("success","El salón fue agregado con éxito");

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
        $salon = Salon::find($id);
        $escuelas = Escuela::all();
        return view("sistema_cobros.salones.edit",[
            "title"=>"Editar salón",
            "salon"=>$salon,
            "escuelas"=>$escuelas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        "nombre"=>"required|string|max:32",
        "capacidad"=>"required|integer|max:100",
        "activo"=>"required|boolean",
        "id_escuela"=>"required|uuid|exists:escuelas,id"
        ]);
        $salon = Salon::find($id);
        $salon->nombre = $request->nombre;
        $salon->id_escuela = $request->id_escuela;
        $salon->capacidad = $request->capacidad;
        $salon->activo = $request->activo;
        $salon->save();
        return back()->with("success","Se actualizó el registro del salón.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->can('Eliminar salon')){
        $record = Salon::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'Salón eliminado con éxito.');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
        }
        return back()->with('error', 'No cuentas con el permiso para eliminar salones.');
    }
}
