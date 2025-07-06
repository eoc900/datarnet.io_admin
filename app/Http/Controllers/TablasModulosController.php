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
            "id_tabla"=>$tabla->id,
            "excel"=>true
        ]);

    }
    public function verCargarDatosTabla(Request $request, string $id_tabla = null)
    {
        // Si no llegó el parámetro vía ruta, lo tomamos de query string
        $id_tabla = $id_tabla ?? $request->get('id_tabla');

        $tablasDisponibles = \App\Services\DatabaseService::obtenerTablasConPrefijo('modulo_');
        $existe_tabla = null;
        $columnas = collect();

        if ($id_tabla) {
            $existe_tabla = TablaModulo::where('id', $id_tabla)->first();
            if ($existe_tabla) {
                $columnas = ColumnaTabla::where("id_tabla", $id_tabla)->get();
            }
        }

        return view("sistema_cobros.tablas_modulos.cargar_datos", [
            "title" => "Cargar datos",
            "id_tabla" => $id_tabla,
            "tabla" => $existe_tabla ? $existe_tabla->nombre_tabla : null,
            "columnas" => $columnas,
            "tablasDisponibles" => $tablasDisponibles
        ]);
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

                    // Ya no necesitas isset, solo haces una comparación directa:
                    'es_llave_primaria' => $primaryKeys[$index] ?? 0,
                    'nullable' => $nullables[$index] ?? 0,
                    'es_foranea' => $es_foranea[$index] ?? 0,

                    'on_table' => ($es_foranea[$index] ?? 0) ? ($on_table[$index] ?? null) : null,
                    'on_column' => ($es_foranea[$index] ?? 0)
                        ? (str_contains($on_row[$index], '.') ? explode('.', $on_row[$index])[1] : $on_row[$index])
                        : null,

                    'activo' => true,
                ]);

                $assoc_nullables[$columna] = $nullables[$index] ?? 0;
                $assoc_limite[$columna] = $request->input("limite_caracteres")[$index] ?? 255;
                $assoc_unicos[$columna] = $unicos[$index] ?? 0;

                if (($es_foranea[$index] ?? 0)) {
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

        if (!empty($resultados)) {
            if (DB::table($tabla->nombre_tabla)->insertOrIgnore($resultados)) {
                return view("sistema_cobros.tablas_modulos.datos_insertados", [
                    "title" => "Se pudieron insertar los datos.",
                    "tabla" => $tabla->nombre_tabla,
                    "excel" => $resultados
                ]);
            } else {
                Log::info('No se pudo hacer el insert');
                return view("sistema_cobros.tablas_modulos.datos_insertados", [
                    "title" => "Error al insertar.",
                    "resultados" => ["Existente" => "El archivo " . $tabla->nombre_tabla . ".xlsx no insertó registros."],
                    "excel" => $resultados
                ]);
            }
        } else {
            Log::info("No se insertaron datos porque el archivo solo tiene encabezados.");
            return view("sistema_cobros.tablas_modulos.datos_insertados", [
                "title" => "No se insertaron datos.",
                "resultados" => ["Vacío" => "El archivo " . $tabla->nombre_tabla . ".xlsx no contenía datos."],
                "excel" => []
            ]);
        }

        
    }

    public function cargarDatosTabla(Request $request)
    {
            $request->validate([
                'id_tabla' => 'required|exists:tablas_modulos,id',
                'archivo' => 'required|file|mimes:xlsx,xls,csv|max:10240'
            ]);

            $tabla = TablaModulo::find($request->id_tabla);
            if (!$tabla) {
                return back()->with(['error' => 'Tabla no encontrada']);
            }

            $ignorarLlavesPrimarias = $request->has('ignorar_llaves_primarias');
            $ignorarCamposVacios = $request->has('ignorar_campos_vacios');

            $archivo = $request->file('archivo');
            $nombreOriginal = str_replace(' ', '_', $archivo->getClientOriginalName());
            $rutaArchivo = $archivo->storeAs('archivos/temporal', $nombreOriginal);
            $filePath = storage_path('app/'.$rutaArchivo);

            try {
                // Obtener columnas esperadas
                $tablaModel = new TablasModulos();
                $columnasEsperadas = $tablaModel->obtenerColumnasTablaDB(
                    $tabla->nombre_tabla,
                    ["id", "updated_at", "created_at"]
                );

                // Cargar el arreglo de registros desde el archivo
                $registros = $tablaModel->obtenerArregloV3(
                    $tabla->nombre_tabla,
                    $nombreOriginal,
                    $request,
                    $columnasEsperadas
                );

                // Eliminar archivo temporal
                unlink($filePath);

                if (empty($registros)) {
                    return back()->with(['error' => 'No se insertó ningún dato']);
                }

                // Procesar registros
                $registrosLimpios = $this->filtrarRegistros($registros, $tabla->nombre_tabla, $columnasEsperadas, $ignorarCamposVacios);



                if (empty($registrosLimpios)) {
                    return back()->with(['error' => 'Todos los registros fueron omitidos por duplicados o vacíos.']);
                }

                DB::table($tabla->nombre_tabla)->insert($registrosLimpios);

                return back()->with(['success' => 'Se insertaron ('.count($registrosLimpios).') registros exitosamente.']);

            } catch (\Exception $e) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                return back()->with([
                    'error' => 'Error al procesar el archivo: '.$e->getMessage()
                ]);
            }
    }

    //Funcion auxiliar cargarDatosTabla
    private function filtrarRegistros(array $registros, string $nombreTabla, array $columnasEsperadas, bool $ignorarCamposVacios): array
    {
        $columnasSinID = array_filter($columnasEsperadas, fn($col) => $col !== 'id');
        $camposUnicos = $this->obtenerCamposUnicos($nombreTabla);

        return collect($registros)
            ->map(function ($fila) use ($columnasSinID) {
                return collect($fila)->only($columnasSinID)->toArray();
            })
            ->filter(function ($fila) use ($ignorarCamposVacios, $camposUnicos, $nombreTabla) {
                if ($ignorarCamposVacios) {
                    if (collect($fila)->contains(fn($v) => is_null($v) || $v === '')) {
                        return false;
                    }
                }

                // Verificar duplicados por campos únicos
                foreach ($camposUnicos as $campo) {
                    if (!isset($fila[$campo])) continue;

                    $existe = DB::table($nombreTabla)
                        ->where($campo, $fila[$campo])
                        ->exists();

                    if ($existe) return false;
                }

                return true;
            })
            ->values()
            ->all();
    }


    private function obtenerCamposUnicos(string $nombreTabla): array
    {
        $dbName = DB::getDatabaseName();

        return DB::table('information_schema.STATISTICS')
            ->select('COLUMN_NAME')
            ->where('TABLE_SCHEMA', $dbName)
            ->where('TABLE_NAME', $nombreTabla)
            ->where('NON_UNIQUE', 0) // UNIQUE = 0
            ->where('INDEX_NAME', '!=', 'PRIMARY')
            ->pluck('COLUMN_NAME')
            ->toArray();
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
