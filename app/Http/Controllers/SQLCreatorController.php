<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DatabaseService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;
use App\Models\SQLCreator;


class SQLCreatorController extends Controller
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
      $registros = DB::table('sql_creator')
        ->select('sql_creator.id','sql_creator.nombre', 'sql_creator.activo', DB::raw("CONCAT(users.name, ' ', users.lastname) as creadoPor"))
        ->join('users','sql_creator.creadoPor','=','users.id')
        ->where('sql_creator.nombre', 'like', "%{$searchFor}%");
       
        
       $sql_creator = [
            "title"=>"Queries",
            "titulo_breadcrumb" => "Queries",
            "subtitulo_breadcrumb" => "Queries",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"/sql_creator",
            "confTabla"=>array(
                "tituloTabla"=>"Queries",
                "placeholder"=>"Buscar sql_creator",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Por nombre del query"],["key"=>"usuario","option"=>"Nombre usuario"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array('nombre','creadoPor','activo'),
                "columns"=>array('Query','Usuario',"Activo"),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(10)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'sql_creator.destroy',
                "routeCreate" => "sql_creator.create",
                "routeEdit" => 'sql_creator.edit', // referente a un método ListadoFormularios
                "routeShow" => 'sql_creator.show',
                "routeIndex" => 'sql_creator.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Queries"
            )];

            return view('sistema_cobros.sql_creator.index',$sql_creator);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //1. Traer todas las tablas que contienen el prefijo módulo_
        $tablas = DatabaseService::obtenerTablasConPrefijo('modulo_');
        return view("sistema_cobros.sql_creator.create",[
            "title"=>"Generar un reporte",
            "tablas"=>$tablas
        ]);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $nombre_query = $request->nombre_query;
        $descripcion = $request->descripcion;
        $tablas = [];
        $columnas = [];
        $funciones = [];
        $joins = [];
        $conditions = [];
        $agrupar = [];
       
        // iterar tabla[]
        foreach($request->input("tabla") as $index=>$tabla){
            $tablas[] = $tabla;
        }

        // iterar columna[]
        if (!empty($request->input("columna"))){
        foreach($request->input("columna") as $columna){
            $columnas[] = $columna;
        }
        }

        // iterar agregaciones[]
        if (!empty($request->input("funcion"))){
            foreach($request->input("funcion") as $index=>$columna_f){
            $funcion = $request->input("funcion")[$index];
            $columna = $request->input("columna_funcion")[$index];
            $alias = $request->input("columna_as")[$index];
            $agregacion = ["funcion"=>$funcion,"columna"=>$columna,"alias"=>$alias];
            $funciones[] = $agregacion;
            }
        }
        

        // iterar joins[]
        if (!empty($request->input("join"))){
        foreach($request->input("join") as $index=>$join){
            
            $arr = explode(".",$request->input("columna_derecha")[$index]);
            $tabla = $arr[0];
            $joinType = $join;
            $on = [$request->input("columna_izquierda")[$index],"=",$request->input("columna_derecha")[$index]];
            $j = ["tabla"=>$tabla,"joinType"=>$joinType,"on"=>$on];
            $joins[] = $j;
        }
        }

         // iterar condiciones_where[]
        if (!empty($request->input("columna_where"))){
        foreach($request->input("columna_where") as $index=>$w){
            
            $where = $w;
            $operator = $request->input("operador_where")[$index];

            if($operator=="between"){
                $where_value = [$request->input("valor_where_1")[$index],$request->input("valor_where_2")[$index]];
            }else{
                $where_value = $request->input("valor_where_1")[$index];
            }

            
            $obj_where = ["columna_where"=>$where,"operator"=>$operator,"where_value"=>$where_value];
            $logic = $request->input("where_logic")[$index];
      
            $condition = ["logic__op"=>$logic,"condition"=>["where_column"=>$where,"operator"=>$operator,"where_value"=>$where_value]];
            $conditions[] = $condition;
        }
        }

        if (!empty($request->input("agrupar_por"))){
            // iterar agrupar[]
            foreach($request->input("agrupar_por") as $index=>$por){
                //V1
                //$agrupar[] = $por;

                //V2
                // Checar si la columna a agrupar es una fecha
                if(!empty($request->input("es_fecha")[$index])){
                    $agrupar = ["columna"=>$por,"es_fecha"=>true,"distribuido_por"=>$request->input("distribuir_por")[$index]];
                }else{
                    $agrupar = ["columna"=>$por,"es_fecha"=>false];
                }
            }
        }

        $resultados = [
            "nombre_query"=>$nombre_query,
            "tablas"=>$tablas,
            "columnas"=>$columnas,
            "joins"=>$joins,
            "agregaciones"=>$funciones,
            "condiciones"=>$conditions,
            "agrupar"=>$agrupar
        ];
            


        // Ejecutar query
        //V1
        //$consulta = $this->generarConsulta($resultados);
        $consulta = $this->generarConsultaV2($resultados);
        $data = $consulta->get();
    
        // Guardar archivo de configuración + Convertir a JSON
        $jsonData = json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        // Guardar en storage/app
        Storage::disk('local')->put('queries/'.$nombre_query.'.json', $jsonData);

        //Guardar reporte
        $SQLCreator = new SQLCreator();
        $SQLCreator->nombre = $nombre_query;
        $SQLCreator->descripcion = $descripcion;
        $SQLCreator->creadoPor = Auth::user()->id;
        $SQLCreator->activo = 1;
        $SQLCreator->save();

        return view('sistema_cobros.sql_creator.tabla',[
            "title"=>"Tabla",
            "nombre_query"=>$nombre_query,
            "mostrar_tabla"=>  1,
            "resultados"=>$data
        ]);
    }



function generarConsulta($estructura) {
    // Iniciar la consulta con la primera tabla
    $query = DB::table($estructura['tablas'][0]);

    // Seleccionar columnas
    $columnas = $estructura['columnas'] ?? [];
    
    // Agregar agregaciones si existen
    if (!empty($estructura['agregaciones'])) {
        foreach ($estructura['agregaciones'] as $agregacion) {
            $columnas[] = DB::raw("{$agregacion['funcion']}({$agregacion['columna']}) AS {$agregacion['alias']}");
        }
    }

    if (!empty($columnas)) {
        $query->select($columnas);
    }

    // Agregar Joins
    if (!empty($estructura['joins'])) {
        foreach ($estructura['joins'] as $join) {
            $tipoJoin = $join['joinType'] === 'leftJoin' ? 'leftJoin' : 'join';
            $query->$tipoJoin($join['tabla'], function ($joinClause) use ($join) {
                $joinClause->on($join['on'][0], $join['on'][1], $join['on'][2]);
            });
        }
    }

    // Agregar condiciones WHERE
    if (!empty($estructura['condiciones'])) {
        $firstCondition = true;
        foreach ($estructura['condiciones'] as $condicion) {
            $logicOp = $condicion['logic__op'] ?? ''; // Puede ser AND u OR
            $where = $condicion['condition'];

            if ($firstCondition) {
                
                // Si el operador es "between"
                if($where['operator']=="between"){
                    $query->whereBetween($where['where_column'], [$where['where_value'][0],  $where['where_value'][1]]);
                }else{
                    $query->where($where['where_column'], $where['operator'], $where['where_value']);
                    $firstCondition = false;
                }
              
            } else {
                if (strtoupper($logicOp) === 'OR') {
                        // Si el operador es "between"
                        if($where['operator']=="between"){
                            $query->orWhereBetween($where['where_column'], [$where['where_value'][0],  $where['where_value'][1]]);
                        }else{
                            $query->orWhere($where['where_column'], $where['operator'], $where['where_value']);
                        }
                  
                } else {
                    $query->where($where['where_column'], $where['operator'], $where['where_value']);
                }
            }
        }
    }

    // Agregar GROUP BY si existe

        // Nueva implementación 'agrupar_por'=>['columna'=>"inscripciones.fecha_inicio","es_fecha"=>true,"distribuido_por"=>["dia","semana","mes"]]
    if (!empty($estructura['agrupar'])) {
        $query->groupBy($estructura['agrupar']);
    }

    // Agregar ORDER BY si existe
    if (!empty($estructura['ordenar'])) {
        foreach ($estructura['ordenar'] as $orden) {
            $query->orderBy($orden['columna'], $orden['direccion'] ?? 'asc');
        }
    }

    return $query;
}

function generarConsultaV2($estructura) {
    // Iniciar la consulta con la primera tabla
    $query = DB::table($estructura['tablas'][0]);

    // Seleccionar columnas
    $columnas = $estructura['columnas'] ?? [];
    
    // Agregar agregaciones si existen
    if (!empty($estructura['agregaciones'])) {
        foreach ($estructura['agregaciones'] as $agregacion) {
            $columnas[] = DB::raw("{$agregacion['funcion']}({$agregacion['columna']}) AS {$agregacion['alias']}");
        }
    }

    // Verificar si hay un 'agrupar_por' con fecha y distribución por día, semana o mes
    if (!empty($estructura['agrupar'])) {
        $agrupar = $estructura['agrupar'];
        
        if (isset($agrupar['es_fecha']) && $agrupar['es_fecha']) {
            $columna = $agrupar['columna'];
             // Filtrar el arreglo y eliminar el elemento que coincida con $columna
            $columnas = array_filter($columnas, function($item) use ($columna) {
                return $item !== $columna;
            });
            $tipo = $agrupar['distribuido_por'] ?? 'dia';

            switch ($tipo) {
                case 'mes':
                    $columnas[] = DB::raw("YEAR($columna) as anio, MONTH($columna) as mes");
                    $query->groupByRaw("YEAR($columna), MONTH($columna)");
                     $query->orderBy("mes","asc");
                    break;

                case 'semana':
                    $columnas[] = DB::raw("YEAR($columna) as anio, WEEK($columna) as semana");
                    $query->groupByRaw("YEAR($columna), WEEK($columna)");
                    $query->orderBy("semana","asc");
                    break;

                case 'dia':
                    $columnas[] = DB::raw("DATE($columna) as dia");
                    $query->groupByRaw("DATE($columna)");
                    $query->orderBy("dia","asc");
                    break;

                default:
                    $query->groupBy($columna);
                    $query->orderBy($columna,"asc");
                    break;
            }
        } else {
            $query->groupBy($agrupar['columna']);
        }
    }

    // Aplicar las columnas al select()
    if (!empty($columnas)) {
        $query->select($columnas);
    }

    // Agregar Joins
    if (!empty($estructura['joins'])) {
        foreach ($estructura['joins'] as $join) {
            $tipoJoin = $join['joinType'] === 'leftJoin' ? 'leftJoin' : 'join';
            $query->$tipoJoin($join['tabla'], function ($joinClause) use ($join) {
                $joinClause->on($join['on'][0], $join['on'][1], $join['on'][2]);
            });
        }
    }

    // Agregar condiciones WHERE
    if (!empty($estructura['condiciones'])) {
        $firstCondition = true;
        foreach ($estructura['condiciones'] as $condicion) {
            $logicOp = $condicion['logic__op'] ?? ''; // Puede ser AND u OR
            $where = $condicion['condition'];

            if ($firstCondition) {
                
                // Si el operador es "between"
                if($where['operator']=="between"){
                    $query->whereBetween($where['where_column'], [$where['where_value'][0],  $where['where_value'][1]]);
                }else{
                    $query->where($where['where_column'], $where['operator'], $where['where_value']);
                    $firstCondition = false;
                }
              
            } else {
                if (strtoupper($logicOp) === 'OR') {
                        // Si el operador es "between"
                        if($where['operator']=="between"){
                            $query->orWhereBetween($where['where_column'], [$where['where_value'][0],  $where['where_value'][1]]);
                        }else{
                            $query->orWhere($where['where_column'], $where['operator'], $where['where_value']);
                        }
                  
                } else {
                    $query->where($where['where_column'], $where['operator'], $where['where_value']);
                }
            }
        }
    }

    // Agregar GROUP BY si existe

        // Nueva implementación 'agrupar_por'=>['columna'=>"inscripciones.fecha_inicio","es_fecha"=>true,"distribuido_por"=>["dia","semana","mes"]]
    // if (!empty($estructura['agrupar'])) {
    //     $query->groupBy($estructura['agrupar']);
    // }

    // Agregar ORDER BY si existe
    if (!empty($estructura['ordenar'])) {
        foreach ($estructura['ordenar'] as $orden) {
            $query->orderBy($orden['columna'], $orden['direccion'] ?? 'asc');
        }
    }

    return $query;
}



    public function show(string $id)
    {
        $SQLCreator = SQLCreator::findOrFail($id);
        $data = Storage::disk('local')->get('queries/'.$SQLCreator->nombre.'.json');
        $jsonDecoded = json_decode($data, true);
        //V1
        //$consulta = $this->generarConsulta($jsonDecoded);
        $consulta = $this->generarConsultaV2($jsonDecoded);
        $resultados = $consulta->get();

         return view('sistema_cobros.sql_creator.tabla',[
            "title"=>"Tabla",
            "nombre_query"=>$SQLCreator->nombre,
            "mostrar_tabla"=>  1,
            "resultados"=>$resultados
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
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
             // Buscar el contacto existente
        $sql = SQLCreator::find($id);

        if (!$sql) {
            return back()->with('error','Query no encontrado');
        }

        // Eliminar el contacto
        Storage::delete('queries/'.$sql->nombre.".json");
        $sql->delete();

        return back()->with('success','Query creado');
    }
}
