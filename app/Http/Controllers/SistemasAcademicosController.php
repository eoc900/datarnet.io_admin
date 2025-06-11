<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SistemaAcademico;
use App\Models\ListadoFormularios;
use App\Models\Alumno;
use App\Models\Code;
use App\Models\Escuela;
use App\Helpers\Mensajes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SistemasAcademicosController extends Controller
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
         $registros = DB::table('sistemas_academicos')->select("id","codigo_sistema","nombre","activo")
                    ->where("nombre","like","%{$searchFor}%")
                    ->orWhere("codigo_sistema","like","%{$searchFor}%")
                    ->orWhere("activo","like","%{$searchFor}%");
                    $escuelas = [
                        "title"=>"Sistemas Académicos",
                        "titulo_breadcrumb" => "Sistemas Académicos",
                        "subtitulo_breadcrumb" => "Visualizar Sistemas Académicos",
                        "go_back_link"=>"#",
                        "formulario"=>"sistemas_academicos", // se utiliza para el form tag
                        "tabla"=>"tabla.sistemas_academicos",
                        "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
                        "urlRoute"=>"sistemas_academicos",
                        "confTabla"=>array(
                            "tituloTabla"=>"Mis Sistemas Académicos",
                            "placeholder"=>"Buscar sistemas académicos",
                            "idSearch"=>"buscarInfoTabla",
                            "valueSearch"=>$searchFor,
                            "idBotonBuscar"=>"btnBuscarTabla",
                            "botonBuscar"=>"Buscar",
                            "filtrosBusqueda"=>array(["key"=>"codigo_sistema","option"=>"Código Sistema"]),
                            "rowCheckbox"=>true,
                            "idKeyName"=>"id",
                            "keys"=>array("codigo_sistema",'nombre',"activo"),
                            "columns"=>array("Código Sistema","Nombre","Activo"),
                            "indicadores"=>true,
                            "numerico"=>true,
                            "botones"=>array('0'=>'btn-outline-danger',
                                                '1'=>'btn-outline-success'),
                            "rowActions"=>array("show","edit","destroy"),
                            "data" => $registros->paginate(5)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                            "routeDestroy" => 'sistemas_academicos.destroy',
                            "routeCreate" => ['formulario','alta_sistemas_academicos'],
                            "routeEdit" => 'sistemas_academicos.edit',
                            "routeShow" => 'sistemas_academicos.show',
                            "routeIndex" => 'tabla',
                            "ajaxRenderRoute" => '/html/tabletareas',
                            "reRenderSection" => ".dynamic_table",
                            "searchFor"=>$searchFor,
                            "count" => $registros->count(),
                            "txtBtnCrear"=>"Agregar una tarea"
                        )
                        

                    ];
            return view('sistema_cobros.sistemas_academicos.index', $escuelas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $escuelas = DB::table('escuelas')->select("id","codigo_escuela","activo")->get();
        $nivelesDropdown = SistemaAcademico::mostrarDropdownNiveles(); 
        $modalidades = SistemaAcademico::mostrarDropdownModalidades();
        return view('sistema_cobros.sistemas_academicos.create',[
            "title"=>"Sistemas Académicos",
            "titulo_breadcrumb" => "Sistemas Académicos",
            "subtitulo_breadcrumb" => "Sistemas",
            "escuelas"=>$escuelas,
            "niveles"=>$nivelesDropdown,
            "modalidades"=>$modalidades
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mensajes = new Mensajes(); // registro de respuestas add(["mensaje"=>"Almacenamiento de acta de nacimiento exitosa","respuesta"=>true])
               // Validar los datos de entrada
            $request->validate([
                'codigo_sistema' => 'required|string|max:32',
                'id_escuela' => 'required|string',
                'modalidad' => 'required|string',
                'nombre' => 'required|string|max:64',
                'activo' => 'required|boolean',
            ]);

            $escuela = DB::table('escuelas')->where("id","=",$request->id_escuela)->first();
            // Crear una nueva instancia de Escuela
            $sistema = new SistemaAcademico([
                'id' => (string) Str::uuid(), // Generar un UUID
                'id_escuela'=>$request->id_escuela,
                'modalidad'=>$request->modalidad,
                'codigo_sistema' => $escuela->codigo_escuela."-".$request->codigo_sistema,
                'nivel_academico' => $request->nivel_academico,
                'nombre' => $request->nombre,
                'creada_por' => Auth::user()->id,
                'activo' => $request->activo,
            ]);

            // Guardar la instancia en la base de datos
            $sistema->save();
            $mensajes->add(array("response"=>true,"message"=>"Se agregó el sistema academico exitosamente"));
            return back()->with('mensajes',$mensajes->log);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sistema = SistemaAcademico::join("escuelas","sistemas_academicos.id_escuela","=","escuelas.id")
        ->select("sistemas_academicos.nombre","sistemas_academicos.codigo_sistema","sistemas_academicos.activo","escuelas.nombre as escuela","escuelas.codigo_escuela")
        ->where('sistemas_academicos.id',"=",$id)
        ->firstOrFail();

     
        $alumnos = Alumno::where('id_sistema_academico', $id)->count();
        return view('administrador.sistemas_academicos.dashboard',[
            'title'=>"Sistema Académico",
            'subtitulo_breadcrumb'=>"",
            'titulo_breadcrumb'=>"",
            "datos"=>[
            "cantidad_alumnos"=>$alumnos,
            "sistema"=>$sistema
        ]]);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sistema = DB::table('sistemas_academicos')->where('sistemas_academicos.id','=',$id)->first();
        $lista = Escuela::all();
        $nivelesDropdown = SistemaAcademico::mostrarDropdownNiveles(); 
        return view('sistema_cobros.sistemas_academicos.edit',[
            'title'=>"Sistema Académico",
            'subtitulo_breadcrumb'=>"",
            'titulo_breadcrumb'=>"",
            'sistema'=>$sistema,
            'escuelas'=>$lista,
            'niveles'=>$nivelesDropdown]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mensajes = new Mensajes(); // registro de respuestas add(["mensaje"=>"Almacenamiento de acta de nacimiento exitosa","respuesta"=>true])
        $escuela = SistemaAcademico::findOrFail($id);     
        $escuela->update([
                'id_escuela'=>$request->id_escuela,
                'codigo_sistema' => $request->codigo_sistema,
                'nivel_academico' => $request->nivel_academico,
                'nombre' => $request->nombre,
                'activo' => $request->activo
        ]);
       $mensajes->add(array("response"=>true,"message"=>"Se editó el sistema académico exitosamente"));
       return back()->with('mensajes',$mensajes->log);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = SistemaAcademico::find($id);
        if($record){
            $record->delete();
            return back()->with('success', 'Sistema académico eliminado con éxito.');
        }
        return back()->with('error', 'Hubo un error al tratar de borrar registro');
    }

}
