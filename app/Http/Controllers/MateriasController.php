<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Mensajes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Materia;

class MateriasController extends Controller
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
         $registros = DB::table('materias')->select("materias.clave",'materias.id',"materias.materia","materias.cuatrimestre","materias.activo")
                    ->where("materias.clave","like","%{$searchFor}%")
                    ->orWhere("materias.activo","like","%{$searchFor}%")
                    ->orWhere("materias.cuatrimestre","like","%{$searchFor}%")
                    ->orderBy('materias.cuatrimestre', 'asc')
                    ->orderBy('materias.clave', 'asc');
                    $materias = [
                        "title"=>"Materias",
                        "titulo_breadcrumb" => "Materias",
                        "subtitulo_breadcrumb" => "Materias",
                        "go_back_link"=>"#",
                        "formulario"=>"materias", // se utiliza para el form tag
                        "tabla"=>"tabla.sistemas_academicos",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"materias",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis materias",
                            "placeholder"=>"Buscar materias",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"clave","option"=>"Clave"],["key"=>"materia","option"=>"Materia"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("clave",'materia','cuatrimestre',"activo"),
                            "columns"=>array("Clave","Materia","Cuatrimestre","Activo"),
                            "indicadores"=>true,
                            "numerico"=>true,
                            "botones"=>array('0'=>'btn-outline-danger',
                                                '1'=>'btn-outline-success'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(15)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'materias.destroy',
                            "routeCreate" => ['formulario','alta_sistemas_academicos'],
                            "routeEdit" => 'materias.edit',
                            "routeShow" => 'materias.show',
                            "routeIndex" => 'tabla',
                            "ajaxRenderRoute" => '/html/tabletareas',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar una materia"
                        )
                        

                    ];
            return view('sistema_cobros.materias.index', $materias);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sistemas = DB::table('sistemas_academicos')
        ->select("sistemas_academicos.id","sistemas_academicos.nombre")
        ->where('sistemas_academicos.activo','=',1)
        ->get();
        
        return view('sistema_cobros.materias.create',[
            "title"=>"Inscripciones",
            "titulo_breadcrumb" => "Inscripciones",
            "subtitulo_breadcrumb" => "Inscripciones",
            "sistemas_academicos"=>$sistemas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           // Validar los datos
        $validated = $request->validate([
            'materia' => 'required|string',
            'cuatrimestre' => 'required|integer',
            'clave' => 'required|string|max:6',
            'creditos' => 'required|string|max:32'
        ]);


        $id = (string) Str::uuid();
        Materia::create([
            'id' => $id,
            //'id_sistema' => $request->id_sistema,
            'materia' => $request->materia,
            'cuatrimestre'=>$request->cuatrimestre,
            'clave' => $request->clave,
            'creditos' => $request->creditos,
            'activo' => $request->activo,
            "seriada"=>$request->seriada
        ]);

        return back()->with('success','Materia generada');
        

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
        $materia = DB::table('materias')->where('materias.id','=',$id)->first();
        $sistemas = DB::table('sistemas_academicos')
        ->select("sistemas_academicos.id","sistemas_academicos.nombre")
        ->where('sistemas_academicos.activo','=',1)
        ->get();

        return view('sistema_cobros.materias.edit',[
            "title"=>"Inscripción",
            "breadcrumb_title" => "Inscripciones",
            "breadcrumb_second" => "Editar Inscripción",
            "materia"=>$materia,
            "sistemas_academicos"=>$sistemas
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mensajes = new Mensajes(); // registro de respuestas add(["mensaje"=>"Almacenamiento de acta de nacimiento exitosa","respuesta"=>true])
        $materia = Materia::findOrFail($id);

             // Validar los datos
        $validated = $request->validate([
            'materia' => 'required|string',
            'cuatrimestre' => 'required|integer',
            'clave' => 'required|string|max:6',
            'creditos' => 'required|string|max:32'
        ]);

     
        $materia->update([
        //'id_sistema'=>$request->id_sistema,
        'cuatrimestre'=>$request->cuatrimestre,
        'creditos'=>$request->creditos,
        'materia'=>$request->materia,
        'clave'=>$request->clave,
        'activo'=>$request->activo,
        'seriada'=>$request->seriada
        ]);
       
        $mensajes->add(array("response"=>true,"message"=>"Se editó el registro de materia"));

       return back()->with('mensajes',$mensajes->log);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::user()->can('Eliminar materia')){
            $record = Materia::find($id);
            if($record){
                $record->delete();
                return back()->with('success', 'Materia eliminada con éxito.');
            }
            return back()->with('error', 'Hubo un error al tratar de borrar registro');
        }
        return back()->with('error', 'No cuentas con el permiso para eliminar materias.');
    }
}
