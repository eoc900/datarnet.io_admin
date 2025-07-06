<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Archivo;
use App\Helpers\TablasModulos;
use App\Models\TablaModulo;
use App\Models\User;


class ArchivosController extends Controller
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
      $registros = DB::table('archivos')
        ->select('archivos.id','archivos.nombre_archivo as nombre','archivos.carpeta','archivos.formato',
        'archivos.tamano', DB::raw("CONCAT(users.name, ' ', users.lastname) as creadoPor"))
        ->join('users','archivos.creadoPor','=','users.id')
        ->where('archivos.nombre_archivo', 'like', "%{$searchFor}%")
        ->orWhere(DB::raw("CONCAT(users.name, ' ',users.lastname)"), 'like', "%{$searchFor}%");
       
        
       $archivos = [
            "title"=>"Archivos",
            "titulo_breadcrumb" => "Archivos",
            "subtitulo_breadcrumb" => "Archivos",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"/archivos",
            "confTabla"=>array(
                "tituloTabla"=>"Archivos",
                "placeholder"=>"Buscar archivos",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Por nombre del archivo"],["key"=>"usuario","option"=>"Nombre usuario"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array('nombre','formato','tamano','carpeta','creadoPor'),
                "columns"=>array('Archivo','Formato','Tamaño','Carpeta','Usuario'),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(10)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'archivos.destroy',
                "routeCreate" => "archivos.create",
                "routeEdit" => 'archivos.edit', // referente a un método ListadoFormularios
                "routeShow" => 'archivos.show',
                "routeIndex" => 'archivos.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Archivos"
            )];

            return view('sistema_cobros.archivos.index',$archivos);
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $archivo = Archivo::find($id);
        if(!$archivo){
            return back()->with("error","No se encontró esta tabla");
        }
        $user = User::find($archivo->creadoPor);

        $Tabla = new TablasModulos();
        $resultados = $Tabla->obtenerArregloV2($archivo->nombre_archivo, $archivo->nombre_archivo,$user->name."_".$user->lastname);
        return view("sistema_cobros.archivos.ver_excel",[
                "title"=>"Se pudieron insertar los datos.",
                "tabla"=>$archivo->nombre_archivo,
                "excel"=>$resultados,
                "id"=>$id,
                "show"=>true]);
    }

    public function descargar($id){
        // $request->validate([
        //     'id'=>"required|exists:archivos,id"
        // ]);

        $archivo = Archivo::findOrFail($id);
        $user = User::find($archivo->creadoPor);
        $rutaArchivo = 'archivos/'.$user->name."_".$user->lastname.'/' . $archivo->nombre_archivo;
        // Verificar si el archivo existe en el almacenamiento
        if (!Storage::exists($rutaArchivo)) {
            return response()->json(['error' => 'Archivo no encontrado'], Response::HTTP_NOT_FOUND);
        }

        // Devolver el archivo como descarga
        return Storage::download($rutaArchivo, $archivo->nombre_archivo);
    }

    public function descargarConfiguracion($tipo, $nombreArchivo){
        // Mapeamos los tipos a rutas
        $rutas = [
            'formulario' => 'formularios',
            'query' => 'queries',
            'dashboard' => 'dashboards',
        ];

        // Verificamos que el tipo sea válido
        if (!array_key_exists($tipo, $rutas)) {
            abort(404, "Tipo de archivo no válido");
        }

        // Construimos la ruta del archivo
        $ruta = $rutas[$tipo] . '/' . $nombreArchivo . '.json';

        // Verificamos que el archivo exista
        if (!Storage::exists($ruta)) {
            abort(404, "Archivo no encontrado");
        }

         return Storage::download($ruta, $nombreArchivo);


    }

    public function verCargarConfiguracion(){
        return view('sistema_cobros.archivos.cargar_configuracion',[
            "title"=>"Cargar archivos de configuracion"
        ]);
    }

    public function cargaConfiguracion(Request $request)
    {
        $request->validate([
            'files.*' => 'required|mimes:json|max:2048',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $archivo) {
                $nombreOriginal = $archivo->getClientOriginalName();
                $archivo->storeAs('configuracion', $nombreOriginal);
            }

            return response()->json(['success' => true, 'mensaje' => 'Archivos cargados con éxito.','mostrar_procesar'=>true]);
        }

        return response()->json(['success' => false, 'mensaje' => 'No se recibieron archivos.'], 400);
    }




    public function vistaModificarArchivo($tipo, $nombreArchivo)
    {
        // Mapeamos los tipos a rutas
        $rutas = [
            'formulario' => 'formularios',
            'query' => 'queries',
            'dashboard' => 'dashboards',
            'informe' => 'informes'
        ];


        // Verificamos que el tipo sea válido
        if (!array_key_exists($tipo, $rutas)) {
            abort(404, "Tipo de archivo no válido");
        }


        // Construimos la ruta del archivo
        $ruta = $rutas[$tipo] . '/' . $nombreArchivo . '.json';

        // Verificamos que el archivo exista
        if (!Storage::exists($ruta)) {
            abort(404, "Archivo no encontrado");
        }

        // Leemos el contenido
        $contenido = Storage::get($ruta);

        // Intentamos decodificar para verificar que sea JSON válido
        try {
            $json = json_decode($contenido, true);
            $contenidoOrdenado = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            $contenidoOrdenado = $contenido; // fallback
        }

        return view('sistema_cobros.archivos.modificar_archivo', [
            'title'=>'modificar archivo',
            'tipo' => $tipo,
            'nombreArchivo' => $nombreArchivo,
            'contenidoJson' => $contenidoOrdenado
        ]);
    }


    public function modificarArchivo(Request $request){
        //dd($request->all());

        $tipo = $request->input("tipo");
        $nombreArchivo = $request->input("nombreArchivo");
        $contenidoJson = $request->input("contenidoJson");

         // Mapeamos los tipos a rutas
        $rutas = [
            'formulario' => 'formularios',
            'query' => 'queries',
            'dashboard' => 'dashboards',
            'informe'=>'informes'
        ];

        // Verificamos que el tipo sea válido
        if (!array_key_exists($tipo, $rutas)) {
            abort(404, "Tipo de archivo no válido");
        }

        // Construimos la ruta del archivo
        $ruta = $rutas[$tipo] . '/' . $nombreArchivo . '.json';

        Storage::put($ruta,  $contenidoJson);

        return back()->with("success","Archivo: ".$nombreArchivo." actualizado con éxito");
    }

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
        if(Auth::user()->can("Eliminar archivos")){
            $archivo = Archivo::find($id); 
            if($archivo){
                $archivo->delete();
                Storage::delete('archivos/'.Auth::user()->name."_".Auth::user()->lastname."/".$archivo->nombre_archivo);
                return back()->with("success","Archivo eliminado con éxito: ".'archivos/'.Auth::user()->name."_".Auth::user()->lastname."/".$archivo->nombre_archivo);
            }
            return back()->with("error","no se pudo eliminar el archivo");
        }
        return back()->with("error","No tienes permiso para eliminar registros.");
    }
}
