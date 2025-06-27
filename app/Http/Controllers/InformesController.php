<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Helpers\TablasModulos;
use App\Services\DatabaseService;
use App\Http\Controllers\FormCreatorController;
use App\Helpers\Informes;
use App\Models\Informe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class InformesController extends Controller
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
      $registros = DB::table('informes')
        ->select('informes.id','informes.identificador','informes.nombre','informes.activo',
        DB::raw("CONCAT(users.name, ' ', users.lastname) as creadoPor"))
        ->join('users','informes.creado_por','=','users.id')
        ->where('informes.nombre', 'like', "%{$searchFor}%")
        ->orWhere('informes.descripcion', 'like', "%{$searchFor}%")
        ->orWhere('informes.identificador', 'like', "%{$searchFor}%")
        ->orWhere(DB::raw("CONCAT(users.name, ' ',users.lastname)"), 'like', "%{$searchFor}%");
       
        
       $informes = [
            "title"=>"Informes",
            "titulo_breadcrumb" => "Informes",
            "subtitulo_breadcrumb" => "Informes",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"/informes",
            "confTabla"=>array(
                "tituloTabla"=>"Informes",
                "placeholder"=>"Buscar informes",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Por nombre del query"],["key"=>"usuario","option"=>"Nombre usuario"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"identificador",
                "keys"=>array('nombre','identificador','creadoPor','activo'),
                "columns"=>array('Título','ID','Usuario',"Activo"),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(10)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'informes.destroy',
                "routeCreate" => "informes.create",
                "routeEdit" => 'informes.edit', // referente a un método ListadoInformes
                "routeShow" => 'informes.show',
                "routeIndex" => 'informes.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Informes"
            )];

            return view('sistema_cobros.informes.index',$informes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $path = 'informes/tmp/config_temp.json';
    
        // Obtener tablas
        $tablas = DatabaseService::obtenerTablasConPrefijo('modulo_');

        // Verificar si hay un archivo de configuración creado
        if (!Storage::exists("informes/tmp/config_temp.json")) {
            // Generar nueva clave si no hay en sesión o el archivo no existe
            $clave = 'informe_' . Str::random(5);        
            $estructura = [
                'clave' => $clave,
                'titulo' => 'nombre aquí',
                'descripcion'=>'',
                'secciones' => []
            ];

            // Guardar estructura inicial en archivo
            Storage::put($path, json_encode($estructura, JSON_PRETTY_PRINT));
            // Guardar la clave en sesión
            session(['clave_json' => $clave]);
        } else {
            // Cargar el contenido existente
            $estructura = json_decode(Storage::get("informes/tmp/config_temp.json"), true);    
            session(['clave_json' => $estructura["clave"]]);
            $clave = $estructura["clave"];
            $nombre = $estructura["titulo"];
            $descripcion = $estructura["descripcion"];
        }
        return view("sistema_cobros.informes.create",[
            "title"=>"Crear un informe",
            'clave' => $clave,
            'nombre' => $nombre ?? '',
            'descripcion'=>$descripcion ??'',
            'estructura' => $estructura,
            'tablas'=> $tablas,
            'id_informe'=>$clave,
            'edicion'=>"false"
        ]);
    }

    public function guardarConfiguracionTemporal(Request $request){


        //   {
        //   "tipo": "texto",                     // Tipo de filtro (podrías tener también "fecha", "numérico", etc.)
        //   "modo_visual": "select2",            // Puede ser: "dropdown", "select2", "input", "botones"
        //   "usar_tabla_externa": true,
        //   "tabla_fuente": "motivos_contacto",
        //   "columna_valor": "id",
        //   "columna_opcion": "descripcion",
        //   "placeholder": "Selecciona un motivo"
        //   }


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        //dd($request->all());
        $tabla = $request->input("tabla_enlazada");
        // Donde guardamos la variable para json
        $resultados = [];

        // Donde se guardaran los filtros y secciones
        // Para las secciones se extrae del documento   $estructura = json_decode(Storage::get("informes/tmp/config_temp.json"), true);
        $filtros = [];
        $secciones = [];

        // Usuarios permitidos
        $usuarios = $request->input('usuarios_permitidos', []);
        // Crear permiso único
        $tipo = $request->input('crear'); // 'formulario' o 'informe'
        $nombre = $request->input('nombre_informe');
        $permiso = '';
        if(!empty($usuarios)){
            $permiso = 'ver ' . $tipo . ' ' . Str::slug($nombre, ' ');
            Permission::firstOrCreate(['name' => $permiso]);
            // Asignar el permiso a los usuarios seleccionados
            foreach ($usuarios as $idUsuario) {
                $usuario = User::find($idUsuario);
                if ($usuario) {
                    $usuario->givePermissionTo($permiso);
                }
            }
        }
        

        $filtros = $this->almacenarFiltros($request);
        
        $resultados["nombre_informe"] = $request->input("nombre_informe");
        $resultados["descripcion_informe"] = $request->input("descripcion_informe");
        $resultados["clave_informe"] = $request->input("clave");
        $resultados["filtros"] = $filtros;
        $resultados["permiso"] = $permiso;
        
        // Obtención de secciones ubicadas en el archivo config_temp.json
        $path = "informes/tmp/config_temp.json";
        $estructura = json_decode(Storage::get($path), true);
        $resultados["secciones"] = $estructura["secciones"];
         
        if (isset($resultados["clave_informe"])) {
                //1. Guardar en la base de datos
            $informe = new Informe();
            $informe->nombre = $resultados["nombre_informe"];
            $informe->identificador = $resultados["clave_informe"];
            $informe->permiso_requerido = $permiso;
            $informe->descripcion = $resultados["descripcion_informe"];
            $informe->creado_por = Auth::user()->id;
            $informe->save();
            //2. Guardar filtros
            $jsonData = json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            //3. Guardar archivo de informe
            Storage::disk('local')->put('informes/'. $resultados["clave_informe"].".json", $jsonData);
            //4. Eliminar el archivo temporal
            Storage::disk('local')->delete('informes/tmp/config_temp.json');
            //5.  Ir a la vista del informe guardado
            return redirect()->route('informes.show', $resultados["clave_informe"])->with('success', '¡Informe guardado correctamente!');

        }

        return back()->with("error","Hubo un error, no se encontró una clave de informe. Lo sentimos.");
                        
    }

    //Actualizar la sección correspondiente
    public function actualizarSeccionInforme(Request $request){

        $path = "informes/tmp/config_temp.json";
        if ($request->filled("editar_informe") && ($request->input("editar_informe") === "true" || $request->input("editar_informe") === true)) {
            $id_informe = $request->input("id_informe") ?? '';
            $path = "informes/{$id_informe}.json";
            if(!Storage::exists($path)){
                return back()->with("error","Lo sentimos hubo un error con el identificador de la sección.");
            }
        }

        $objeto = [];

        \Log::info($request->all());
        //dd($request->all());
    
        // Obtener el elemento de configuracion y el index de sección con el id
        $elemento = Informes::obtenerConfiguracionSeccion($path,$request->id);
        $objeto["tablas_seleccionadas"] = $request->tablas_seleccionadas_query;
        $objeto["columnas_seleccionadas"] = $request->seleccionar;
        $objeto["joins"] = $request->input('joins'); // 🔥 AQUI agregamos los joins
    
        //WHERE 
        $whereRaw =$request->input("where", []);
        $ordenCondiciones = json_decode($request->input('orden_condiciones'), true);
        $where_logico = $request->input('where_logico', []);
        $whereLogicoGrupal = $request->input("where_logico_grupal", []);
        $whereLogicoSubgrupo = $request->input("where_logico_subgrupo", []);
        $condicionesWhere = Informes::estructurarCondiciones(
            $whereRaw,
            $whereLogicoGrupal,
            $whereLogicoSubgrupo,
            $where_logico,
            $ordenCondiciones
        );
        //dd($condicionesWhere);
        $objeto["where"] = $condicionesWhere;
        $objeto["agregados"] = $request->input('agregados',[]);
        $objeto["group_by"] = $request->input('group_by',[]);

        //Order BY
        $orderByRaw = $request->input('order_by', []); // array de strings tipo: "columna|direccion"
        $orderBy = [];

        foreach ($orderByRaw as $orden) {
            [$col, $dir] = explode('|', $orden);
            $orderBy[] = [
                'columna' => $col,
                'direccion' => $dir
            ];
        }
        $objeto["order_by"] = $orderBy;

        // Limit
        $usarLimit = $request->has('usar_limit');
        $limit = $usarLimit ? intval($request->input('limit')) : null;
        $objeto["limit"] = $limit;

        $elemento["query"] = $objeto;

        // Si hay titulo de tarjeta
        if($request->input("tarjeta_titulo")){
            $elemento["tarjeta_titulo"] = $request->input("tarjeta_titulo");
        }


        // Si hay input grafica 
        if ($request->input("tipo") === "grafica") {
            $elemento["grafica"] = [
                "tipo" => $request->input("configuracion_grafica.tipo_grafica"),
                "label_columna" => $request->input("configuracion_grafica.label"),
                "valor_columna" => $request->input("configuracion_grafica.valor"),
                "titulo" => $request->input("configuracion_grafica.titulo"),
                // Puedes agregar más configuraciones opcionales aquí:
                "stacked" => $request->input("stacked", false),
                "mostrar_leyenda" => $request->input("mostrar_leyenda", true),
                "color_personalizado" => $request->input("color_grafica") // si lo incluyes
            ];
        }

        //Obtener la configuracion actual y modificar las seccion por medio del index
        $estructura = json_decode(Storage::get($path), true);
        $estructura["secciones"][$elemento["index"]] = $elemento;

        // Guardar la nueva configuración
        Storage::put($path, json_encode($estructura, JSON_PRETTY_PRINT));

        return back()->with("success","sección configurada: ".$request->id);
    }

    // Guardamos los filtros
    public function autoguardadoParcial(Request $request){
        //dd($request->all());
         \Log::info($request->all());
        $path = "informes/tmp/config_temp.json";
        $estructura = json_decode(Storage::get($path), true);
        $filtros = $this->almacenarFiltros($request);
        $estructura["filtros"]=$filtros;
        $estructura["titulo"]=$request->input("nombre_informe");;
        $estructura["descripcion"]=$request->input("descripcion_informe");
        // Guardar la nueva configuración
        Storage::put($path, json_encode($estructura, JSON_PRETTY_PRINT));
        return response()->json([
            "status" => "ok",
            "mensaje" => "Guardado parcial realizado.",
            "filtros" => $filtros
        ]);
    }

    public function almacenarFiltros(Request $request): array
    {
        $filtros = [];

        foreach($request->input("type", []) as $type) {

            // Filtro de fecha
            if ($type === "date" && $request->has('filtro_fecha')) {
                $filtros["date"] = [
                    "type" => "date",
                    "default_start" => $request->input("default_start", null),
                    "default_end" => $request->input("default_end", null),
                ];
            }

            // Filtro de texto
            if ($type === "text" && $request->has('filtro_texto')) {

                if ($request->input("tabla_enlazada_activado") === "true" || $request->input("tabla_enlazada_activado") === true) {
                    $filtros["text"] = [
                        "type" => "text",
                        "mode" => "tabla_enlazada",
                        "tabla_enlazada_activado" => $request->input("tabla_enlazada_activado"),
                        "tabla_enlazada" => $request->input("tabla_enlazada"),
                        "texto_opcion_tabla_enlazada" => $request->input("texto_opcion_tabla_enlazada"),
                        "valor_opcion_tabla_enlazada" => $request->input("valor_opcion_tabla_enlazada"),
                        "formato_mostrar_opciones" => $request->input("formato_mostrar_opciones")
                    ];
                }
                elseif ($request->input("modo_visual_filtro_texto") === "select2") {

                    $buscar_en = explode(",", $request->input("campos_busqueda")[0] ?? '');
                    $campos_concatenados = explode(",", $request->input("campos_concatenados")[0] ?? '');
                    $retornar = explode(",", $request->input("campos_respuesta")[0] ?? '');
                    $principal = $request->input("principal");
                    $tabla = $request->input("tabla_enlazada") ?? "tabla";

                    $name = "select2_" . $tabla;
                    $label = "Buscar por";
                    $endpoint = "ejemplo_select2";
                    $id = "buscar_" . $tabla;

                    $columnas = [];
                    foreach ($retornar as $elemento) {
                        $partes = explode(".", $elemento);
                        if (count($partes) === 2) {
                            $columnas[] = $partes[1];
                        }
                    }

                    // Guardar archivo para Select2
                    $informes = new FormCreatorController();
                    $documento_select2 = $name . ".json";
                    $informes->generarArchivoJSONSelect2($tabla, $retornar, $buscar_en, $principal, $documento_select2, $campos_concatenados);

                    $filtros["text"] = [
                        "type" => "text",
                        "mode" => "select2",
                        "tabla" => $tabla,
                        "buscar_en" => $buscar_en,
                        "campos_concatenados" => $campos_concatenados,
                        "retornar" => $columnas,
                        "principal" => $principal,
                        "name" => $name,
                        "placeholder" => $label,
                        "endpoint" => $endpoint,
                        "archivo" => $documento_select2,
                        "id" => $id
                    ];
                }
                else {
                    $filtros["text"] = [
                        "type" => "text",
                        "mode" => $request->input("modo_visual_filtro_texto"),
                        "valores_boton" => $request->input("valores_boton"),
                        "textos_boton" => $request->input("textos_boton")
                    ];
                }
            }
        }

        return $filtros;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $path = "informes/{$id}.json";

        if (!Storage::exists($path)) {
            return view('sistema_cobros.commons.404', ["title" => "Error 404"]);
        }

        $data = Storage::disk('local')->get($path);
        $jsonDecoded = json_decode($data, true);

        // Título general
        $jsonDecoded["titulo"] = $jsonDecoded["nombre_informe"];
        $jsonDecoded["title"] = $jsonDecoded["nombre_informe"];

        // Parámetros desde la URL
        $fechaInicio = $request->query('inicio');
        $fechaFin = $request->query('finaliza');
        $texto = $request->query('texto');

        $fechaInicio = $request->query('inicio') 
            ?? Carbon::now()->startOfMonth()->toDateString(); // Primer día del mes
        $fechaFin = $request->query('finaliza') 
            ?? Carbon::now()->endOfMonth()->toDateString();   // Último día del mes

        $jsonDecoded["default_start"] = $fechaInicio;
        $jsonDecoded["default_end"] = $fechaFin;
        $filtros = [
            'fecha_inicial' => Carbon::parse($fechaInicio)->startOfDay()->toDateTimeString(),
            'fecha_finaliza' => Carbon::parse($fechaFin)->endOfDay()->toDateTimeString(),
            'dos_fechas' => Carbon::parse($fechaInicio)->startOfDay()->format('Y-m-d H:i:s') . ',' . Carbon::parse($fechaFin)->endOfDay()->format('Y-m-d H:i:s'),
            'texto_busqueda' => $request->query('texto'),
        ];


       if (
            isset($jsonDecoded["filtros"]) &&
            isset($jsonDecoded["filtros"]["text"]) &&
            isset($jsonDecoded["filtros"]["text"]["mode"]) &&
            $jsonDecoded["filtros"]["text"]["mode"] == "tabla_enlazada"
        ) {
            // Instancia del query sin ejecutarlo aún
            $query = DB::table($jsonDecoded["filtros"]["text"]["tabla_enlazada"])
                ->select(
                    $jsonDecoded["filtros"]["text"]["valor_opcion_tabla_enlazada"] . " as value",
                    $jsonDecoded["filtros"]["text"]["texto_opcion_tabla_enlazada"] . " as option"
                );

            // Log del SQL antes de ejecutar
            $sql = $query->toSql(); // SQL con ? placeholders
            $bindings = $query->getBindings();

            // Interpolación opcional
            $sqlCompleto = vsprintf(str_replace('?', "'%s'", $sql), $bindings);

            Log::info("SQL generado informes:", [
                'query' => $sql,
                'bindings' => $bindings,
                'sql_completo' => $sqlCompleto
            ]);

            // Ahora sí ejecutamos y guardamos resultados
            $resultados = $query->get();
            Log::info("Resultados de la tabla enlazada:", ['resultados' => $resultados]);

            // Inyectamos en el json
            $jsonDecoded["filtros"]["text"]["resultados"] = $resultados;
            $jsonDecoded["filtros"]["text"]["label"] = "Buscar por";
        }



        // Recorremos cada sección para ejecutar su query si existe
        foreach ($jsonDecoded["secciones"] as $index => $seccion) {
            $seccion["resultados"] = isset($seccion['query'])
                ? collect(Informes::ejecutarConsulta($seccion['query'], $filtros))
                : collect();
            $jsonDecoded["secciones"][$index] = $seccion;
        }
        return view("sistema_cobros.informes.show", $jsonDecoded);
}

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $path = "informes/{$id}.json";
        

         // Verificar si hay un archivo de configuración creado
        if (!Storage::exists($path)) {
            return view('sistema_cobros.commons.404',["title"=>"Error 404"]);
        } else {
            $tablas = DatabaseService::obtenerTablasConPrefijo('modulo_');
            // Cargar datos del contenido existente
            $estructura = json_decode(Storage::get($path), true);              
            $clave = $estructura["clave_informe"];
            $nombre = $estructura["nombre_informe"];
            $descripcion = $estructura["descripcion_informe"];
        }
        return view("sistema_cobros.informes.edit",[
            "title"=>"Edición de informe",
            'clave' => $clave,
            'nombre' => $nombre ?? '',
            'descripcion'=>$descripcion ??'',
            'estructura' => $estructura,
            'tablas'=> $tablas,
            'id_informe'=>$id,
            'edicion'=>"true"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         //dd($request->all());

        // Donde guardamos la variable para json
        $resultados = [];

        // Donde se guardaran los filtros y secciones
        // Para las secciones se extrae del documento   $estructura = json_decode(Storage::get("informes/tmp/config_temp.json"), true);
        $filtros = [];
        $secciones = [];

        $filtros = $this->almacenarFiltros($request);
        
        $resultados["nombre_informe"] = $request->input("nombre_informe");
        $resultados["descripcion_informe"] = $request->input("descripcion_informe");
        $resultados["clave_informe"] = $request->input("clave");
        $resultados["filtros"] = $filtros;
        
        // Obtención de secciones ubicadas en el archivo config_temp.json
        $path = "informes/{$id}.json";
        $estructura = json_decode(Storage::get($path), true);
        $resultados["secciones"] = $estructura["secciones"];
         
        if (isset($resultados["clave_informe"])) {
                //1. Guardar en la base de datos
            $informe = Informe::where('identificador', $id)->first();
            if (!$informe) {
                return back()->with('error', 'No se encontró el informe a actualizar.');
            }
            $informe->nombre = $resultados["nombre_informe"];
            $informe->descripcion = $resultados["descripcion_informe"];            
            $informe->creado_por = Auth::user()->id;
            $informe->save();
            //2. Guardar filtros
            $jsonData = json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            //3. Guardar archivo de informe
            Storage::disk('local')->put('informes/'. $resultados["clave_informe"].".json", $jsonData);

            return back()->with('success', '¡Informe guardado correctamente!');

        }

        return back()->with("error","Hubo un error, no se encontró una clave de informe. Lo sentimos.");
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        if (!Auth::user()->can('Eliminar informes')) {
            return back()->with('error', 'No tienes permiso para eliminar registros.');
        }

        $informe = Informe::where('identificador', $id)->first();

        if (!$informe) {
            return back()->with('error', 'No se pudo encontrar el informe: ' . $id);
        }

        $informe->delete();

        // Verifica si el archivo existe antes de intentar borrarlo
        if (Storage::exists('informes/' . $id . '.json')) {
            Storage::delete('informes/' . $id . '.json');
        }

        return back()->with('success', 'El informe ha sido eliminado con éxito.');
    }

}
