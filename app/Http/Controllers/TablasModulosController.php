<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\User;
use App\Models\TablaModulo;
use App\Models\TipoDato;
use App\Models\ColumnaTabla;
use App\Models\Archivo;
use App\Helpers\TablasModulos;
use App\Services\DatabaseService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;


class TablasModulosController extends Controller
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
      $registros = DB::table('tablas_modulos')
        ->select('tablas_modulos.id','tablas_modulos.nombre_tabla as nombre','tablas_modulos.qty_columnas as columnas',
        'tablas_modulos.activo', DB::raw("CONCAT(users.name, ' ', users.lastname) as creadoPor"))
        ->join('users','tablas_modulos.creadoPor','=','users.id')
        ->where('tablas_modulos.nombre_tabla', 'like', "%{$searchFor}%")
        ->orWhere(DB::raw("CONCAT(users.name, ' ',users.lastname)"), 'like', "%{$searchFor}%");
       
        
       $tablas_modulos = [
            "title"=>"Tablas en la base de datos",
            "titulo_breadcrumb" => "Base de datos",
            "subtitulo_breadcrumb" => "Archivos",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"/tablas_modulos",
            "confTabla"=>array(
                "tituloTabla"=>"Archivos",
                "placeholder"=>"Buscar tablas modulos",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Por nombre de tabla"],["key"=>"usuario","option"=>"Nombre usuario"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array('nombre','activo','columnas','creadoPor'),
                "columns"=>array('Tabla','Activa','# Cols','Usuario'),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","destroy"),
                "data" => $registros->paginate(10)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'tablas_modulos.destroy',
                "routeCreate" => "tablas_modulos.create",
                "routeEdit" => 'tablas_modulos.edit', // referente a un método ListadoFormularios
                "routeShow" => 'tablas_modulos.show',
                "routeIndex" => 'tablas_modulos.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Tablas"
            )];

            return view('sistema_cobros.tablas_modulos.index',$tablas_modulos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lista_usuarios = User::all();
        $lista_tablas_modulo = DB::table("tablas_modulos as tb")
        ->select("tb.nombre_documento","tb.qty_columnas","tb.activo","columnas_tablas.id_columna","columnas_tablas.tipo_dato")
        ->join("columnas_tablas","tb.id","=","columnas_tablas.id_tabla")
        ->get();

        return view("sistema_cobros.tablas_modulos.create",[
            "title"=>"Poblar base de datos",
            "usuarios"=>$usuarios,
            "tablas"=>$lista_tablas_modulo
        ]);
    }

    // Formulario de carga de archivos
    public function crearArchivo(){
        return view("sistema_cobros.tablas_modulos.create",[
            "title"=>"Crear tabla"
        ]);
    }

    // Insertar el archivo de excel o csv a un directorio
    public function insertarArchivo(Request $request){

        $request->validate([
            'archivo' => 'required|mimes:csv,xlsx,xls|max:2048',
            'nombre_archivo' => 'required|string|regex:/^[a-zA-Z0-9_]+$/'
        ]);
            $prefijo = "modulo_";
        // ----> Almacenamiento en nuestro folder
            $archivo = $request->file('archivo');
            $nombreArchivo = $prefijo.$request->nombre_archivo;
            $extension = $archivo->getClientOriginalExtension();
            $nuevoNombre = $nombreArchivo . '.' . $extension;

            $Tabla = new TablasModulos();


            // 1. Existe ese documento en la base de datos?
            $existe_archivo = Archivo::where('nombre_archivo', $nuevoNombre)->first();
            $existe_tabla = TablaModulo::where('nombre_tabla',$nombreArchivo)->first();
            if($existe_archivo || $existe_tabla){
              
              
                return back()->with([
                    "error"=>"Ya existe esta tabla",
                    "link_cargar_datos"=>route('ver_cargar.datos',$existe_tabla->id)
                ]);
            }

            // Guardar el archivo en una carpeta privada 
            $directorioUsuario = Auth::user()->name."_".Auth::user()->lastname."/";
            $rutaArchivo = $archivo->storeAs('archivos/'.$directorioUsuario, $nuevoNombre, 'local'); // Guardado en storage/app
            // Almacenamiento en nuestro folder <----

            $Archivo = new Archivo();
            $Archivo->id = (string) Str::uuid();
            $Archivo->nombre_archivo = $nuevoNombre;
            $Archivo->tamano = $archivo->getSize();
            $Archivo->formato = $extension;
            $Archivo->carpeta = $directorioUsuario;
            $Archivo->creadoPor =  Auth::user()->id;
            $Archivo->save();



            // ----> crear un tabla en la base de datos
            $tabla = new TablaModulo();
            $tabla->nombre_tabla = $nombreArchivo;
            $tabla->qty_columnas = $request->qty_columnas ?? null;
            $tabla->creadoPor = Auth::user()->id;
            $tabla->activo = $request->activo;
            $tabla->save();

       
        // ----> Retornar el nombre de las columnas
        $columnas = $Tabla->leerColumnas($nuevoNombre);
        $tablas_disponibles = DatabaseService::obtenerTablasConPrefijo('modulo_');


        // ----> Traer lista de tipos de datos
        $tipos_datos = TipoDato::all();

        // Enviar un arreglo con información
        return view('sistema_cobros.tablas_modulos.definir_columnas',[
            "title"=>"Definir columnas",
            'success' => "Archivo subido correctamente: {$nuevoNombre}",
            'archivo_info' => [
                'nombre' => $nuevoNombre,
                'tipo' => $archivo->getClientOriginalExtension(),
                'tamano' => $archivo->getSize(),
                'columnas'=> $columnas
            ],
            "tipos_datos"=>$tipos_datos,
            "tablas"=>$tablas_disponibles,
            "id_tabla"=>$tabla->id
        ]);

    }

    public function verCargarDatosTabla(string $id_tabla){
        $existe_tabla = TablaModulo::where('id',$id_tabla)->first();
        
        if($existe_tabla){
            $columnas = ColumnaTabla::where("id_tabla",$id_tabla)->get();
            return view("sistema_cobros.tablas_modulos.cargar_datos",[
                "title"=>"Cargar datos",
                "id_tabla"=>$id_tabla,
                "tabla"=>$existe_tabla->nombre_tabla,
                "columnas"=>$columnas
            ]);
        }
        return "No se encontraron datos";
    }

    // Definir las columnas
    public function definirColumnas(){
        return view('sistema_cobros.tablas_modulos.definir_columnas',["title"=>"Definir columnas"]);
    }

    public function insertarColumnas(Request $request){

        $columnas = $request->input('columna'); // Recibe el array de nombres de columnas
        $tipos = $request->input('tipo_dato'); // Recibe el array de tipos de datos
        $id_tabla = $request->input("id_tabla");
        $unicos = $request->input("es_unico", []);
        $es_foranea = $request->input("es_foranea", []);
        $on_table = $request->input("on_table", []);
        $on_row = $request->input("on_row", []);


       
        if (count($columnas) !== count($tipos)) {
            return back()->with(['error' => 'Los arraglos no tienen la misma cantidad de elementos']);
        }

        $tabla = TablaModulo::find($id_tabla);
    


        $primaryKeys = $request->input("primary_key", []);
        $nullables = $request->input("es_null", []);
        $assoc_nullables = [];
        $assoc_limite = [];
        $assoc_unicos = [];
        $assoc_foraneas = [];


        foreach ($columnas as $index => $columna) {
           ColumnaTabla::create([
                    'nombre_columna' => $columna,
                    'id_tabla' => $id_tabla,
                    'tipo_dato' => $tipos[$index] ?? "varchar",
                    'qty_caracteres' => $request->input("limite_caracteres")[$index] ?? 255,
                    'es_llave_primaria' => isset($primaryKeys[$index]),
                    'nullable' => ($nullables[$index] ?? null) === "true",
                    'es_foranea' => isset($es_foranea[$index]),
                    'on_table' => isset($es_foranea[$index]) ? ($on_table[$index] ?? null) : null,
                    'on_column' => isset($es_foranea[$index]) ? (str_contains($on_row[$index], '.') ? explode('.', $on_row[$index])[1] : $on_row[$index]) : null,
                    'activo' => true,
                ]);

                $assoc_nullables[$columna] = ($nullables[$index] ?? null) === "true";
                $assoc_limite[$columna] = $request->input("limite_caracteres")[$index] ?? 255;
                $assoc_unicos[$columna] = isset($unicos[$index]);

                if (isset($es_foranea[$index])) {
                    $on_table_value = $on_table[$index] ?? null;
                    $on_column_value = $on_row[$index] ?? null;

                    if ($on_table_value && $on_column_value && $on_column_value !== "false") {
                        $on_column_parsed = str_contains($on_column_value, '.')
                            ? explode('.', $on_column_value)[1]
                            : $on_column_value;

                        $assoc_foraneas[$columna] = [
                            'tabla' => $on_table_value,
                            'columna' => $on_column_parsed
                        ];
                    }
                }


        }
        // ----> Traemos la info del registro de tablas_modulos
        //dd($assoc_limite);

     




        //----> Vamos a generar una tabla en la base de datos
        $Tabla = new TablasModulos();

        $resultados = $Tabla->obtenerArregloV2($tabla->nombre_tabla, $tabla->nombre_tabla.".xlsx");

        if(!$Tabla->existeTabla($tabla->nombre_tabla)){
            $Tabla->crearTablaDinamica(
            $tabla->nombre_tabla,
            $columnas,
            $tipos,
            null,
            $assoc_nullables,
            $assoc_limite,
            $assoc_foraneas,
            $assoc_unicos
            );

        }

        if(DB::table($tabla->nombre_tabla)->insertOrIgnore($resultados)){
            return view("sistema_cobros.tablas_modulos.datos_insertados",[
                "title"=>"Se pudieron insertar los datos.",
                "tabla"=>$tabla->nombre_tabla,
                "excel"=>$resultados]);
        }else{
            Log::info('No se pudo hacer el insert');
              return view("sistema_cobros.tablas_modulos.datos_insertados",[
                "title"=>"Error.",
                "resultados"=>["Existente"=>"El archivo ".$tabla->nombre_tabla.".xlsx"],
                "excel"=>$resultados]);
        }
        
    }

    public function cargarDatosTabla(Request $request)
    {
        $request->validate([
            'id_tabla' => 'required|exists:tablas_modulos,id',
            'archivo' => 'required|file|mimes:xlsx,xls,csv|max:10240' // 10MB máximo
        ]);

        $tabla = TablaModulo::find($request->id_tabla);
        
        if (!$tabla) {
            return response()->json(['error' => 'Tabla no encontrada'], 404);
        }

        // Procesar el archivo subido
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            
            // Validar extensión
            $extension = $archivo->getClientOriginalExtension();
            if (!in_array($extension, ['xlsx', 'xls', 'csv'])) {
                return response()->json(['error' => 'El archivo debe ser un documento Excel (xlsx, xls) o CSV'], 400);
            }

            // Limpiar el nombre del archivo
            $nombreOriginal = str_replace(' ', '_', $archivo->getClientOriginalName());
            
            // Guardar en storage temporal
            $rutaArchivo = $archivo->storeAs('archivos/temporal', $nombreOriginal);
            $filePath = storage_path('app/'.$rutaArchivo);

            try {
                // Obtener columnas esperadas
                $tablaModel = new TablasModulos();
                $columnasEsperadas = $tablaModel->obtenerColumnasTablaDB(
                    $tabla->nombre_tabla,
                    ["id", "updated_at", "created_at"]
                );

                // Procesar el archivo
                $resultados = $tablaModel->obtenerArregloV3(
                    $tabla->nombre_tabla,
                    $nombreOriginal,
                    $request,
                    $columnasEsperadas
                );

                // Eliminar el archivo temporal después de procesarlo
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                if(!empty($resultados)){
                    DB::table($tabla->nombre_tabla)->insert($resultados);
                    return back()->with(["success"=>"Se insertaron los (".count($resultados).") registros exitosamente."]);
                }else{
                    return back()->with(["error"=>"No se insertó ningún dato."]);
                }
                

            } catch (\Exception $e) {
                // Asegurarse de eliminar el archivo incluso si hay errores
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                
                return back()->with([
                    'error' => 'Error al procesar el archivo: '.$e->getMessage()
                ]);
            }
        }

        return response()->json(['error' => 'No se encontró archivo para procesar'], 400);
    }


  

    public function storeArchivo(Request $request){

    }

    public function store(Request $request)
    {
        // 1. Guardar la tabla en la base de datos + prefijo
        $Tabla = new TablasModulos();
        $prefijo = "modulo";
        $nombre_tabla = $request->nombre_tabla;

        // Checar que no exista la tabla
        if($Tabla->existeTabla($prefijo."_".$nombre_tabla)){
            return back()->with("error","Esta tabla ya existe: ".$prefijo."_".$nombre_tabla);
        }

         $llavePrimaria = "id";
         $nombres = $request->nombres;
         $columnas = $request->columnas;


    }

    public function testDocument(Request $request){
        try {
            $filePath = storage_path("app/archivos/".Auth::user()->name."_".Auth::user()->lastname."/"."{$request->archivo}.xlsx");
             // Verifica si el archivo existe
            if (!file_exists($filePath)) {
                return false;
            }
            $response = [];
            $spreadsheet = IOFactory::load($filePath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            foreach($sheetData as $index=>$arr){
                if(count($arr)>2 || count($arr)<2){
                    $response[] = "El registro: ".$index." no cuenta con el mismo número de columnas";
                }
            }

            // return response()->json($sheetData);
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error("Error al insertar en la BD: " . $e->getMessage());
        }
    }


    public function show(string $id)
    {
        $tabla = TablaModulo::find($id);
        if(!$tabla){
            return back()->with("error","No se encontró esta tabla");
        }


        // Obtener las columnas 
        $TablasHelper = new TablasModulos();
        $columnas_db = $TablasHelper->obtenerColumnasTablaDB($tabla->nombre_tabla,["created_at","updated_at"]);


        //falta hacer un limit
        // $columnas = ColumnaTabla::where('id_tabla',$tabla->id)->pluck('nombre_columna')->toArray(); 

        $resultados = !empty($columnas_db) 
        ? DB::table($tabla->nombre_tabla)
            ->select($columnas_db)
            ->limit(100) // Puedes ajustar el límite según lo necesario
            ->get() 
        : null;
        

     
        return view("sistema_cobros.tablas_modulos.ver_tablas",[
                "title"=>"Se pudieron insertar los datos.",
                "tabla"=>$tabla->nombre_tabla,
                "datos"=>$resultados,
                "id"=>$id,
                "columnas"=>$columnas_db
                ]);
    }


public function descargarCSV($tabla)
{
    // Obtener los nombres de las columnas dinámicamente
          // Obtener las columnas 
        $TablasHelper = new TablasModulos();
        $columnas_db = $TablasHelper->obtenerColumnasTablaDB($tabla,["created_at","updated_at","id"]);

    // Obtener los datos de la tabla
    $datos = !empty($columnas_db) 
        ? DB::table($tabla)
            ->select($columnas_db) // Puedes ajustar el límite según lo necesario
            ->get() 
        : null;

    if($datos!=null){
        // Convertir los resultados a un array
        $csvData = [];
        $csvData[] = $columnas_db; // Primera fila: encabezados

        foreach ($datos as $fila) {
            $csvData[] = array_values((array) $fila); // Convertir objeto a array
        }

        // Crear el contenido CSV
        $callback = function () use ($csvData) {
            $archivo = fopen('php://output', 'w');
            foreach ($csvData as $fila) {
                fputcsv($archivo, $fila);
            }
            fclose($archivo);
        };

        // Configurar la respuesta como CSV
        $nombreArchivo = 'datos_' . now()->format('Ymd_His') . '.csv';
        return Response::stream($callback, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $nombreArchivo . '"',
        ]);
    }

    return back()->with("error","No se pudo concluir la descarga");
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
        if(Auth::user()->can("Eliminar tablas modulos")){
            $tabla = TablaModulo::find($id);
            if($tabla){
                ColumnaTabla::where('id_tabla', $tabla->id)->delete();
                Archivo::where('nombre_archivo', $tabla->nombre_tabla)->delete();
                Schema::dropIfExists($tabla->nombre_tabla);
                Storage::delete('archivos/'.Auth::user()->name."_".Auth::user()->lastname."/".$tabla->nombre_tabla.".xlsx"); // !!!! NECESITA MEJORARSE
                $tabla->delete();
                return back()->with("success","La tabla fue eliminada con éxito");
            }
            return back()->with("error","no se pudo eliminar el archivo");
        }

        return back()->with("error","No tienes permiso para eliminar registros.");
      
    }
}
