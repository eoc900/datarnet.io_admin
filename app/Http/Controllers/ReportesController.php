<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DatabaseService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;


class ReportesController extends Controller
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
      $registros = DB::table('reportes')
        ->select('reportes.id','reportes.nombre', 'reportes.activo')
        ->where('reportes.nombre', 'like', "%{$searchFor}%");
       
        
       $reportes = [
            "title"=>"Reportes",
            "titulo_breadcrumb" => "Reportes",
            "subtitulo_breadcrumb" => "Reportes",
            "go_back_link"=>"#",
            // "formulario"=>"escuelas", // se utiliza para el form tag
            "view"=>"sistema_cobros.tablas.plantilla", //No cambia, se mantiene así
            "urlRoute"=>"/reportes",
            "confTabla"=>array(
                "tituloTabla"=>"Reportes",
                "placeholder"=>"Buscar reportes",
                "idSearch"=>"buscarInfoTabla",
                "valueSearch"=>$searchFor,
                "idBotonBuscar"=>"btnBuscarTabla",
                "botonBuscar"=>"Buscar",
                "filtrosBusqueda"=>array(["key"=>"nombre","option"=>"Por nombre de reporte"],["key"=>"usuario","option"=>"Nombre usuario"]),
                "rowCheckbox"=>true,
                "idKeyName"=>"id",
                "keys"=>array('nombre','activo'),
                "columns"=>array('Reporte',"Activo"),
                "indicadores"=>true,
                "botones"=>array('0'=>'btn-outline-danger',
                                    '1'=>'btn-outline-success'),
                "rowActions"=>array("show","edit","destroy"),
                "data" => $registros->paginate(10)->appends(["page"=>$page,"search"=>$searchFor,"filter"=>$filter]),
                "routeDestroy" => 'reportes.destroy',
                "routeCreate" => "reportes.create",
                "routeEdit" => 'reportes.edit', // referente a un método ListadoFormularios
                "routeShow" => 'reportes.show',
                "routeIndex" => 'reportes.index',
                "searchFor"=>$searchFor,
                "count" => $registros->count(),
                "txtBtnCrear"=>"Reportes"
            )];

            return view('sistema_cobros.reportes.index',$reportes);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //1. Traer todas las tablas que contienen el prefijo módulo_
        $tablas = DatabaseService::obtenerTablasConPrefijo('modulo_');
        return view("sistema_cobros.reportes.create",[
            "title"=>"Generar un reporte",
            "tablas"=>$tablas
        ]);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $nombre_reporte = $request->nombre_reporte;
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
            $where_value = $request->input("valor_where")[$index];
            $obj_where = ["columna_where"=>$where,"operator"=>$operator,"where_value"=>$where_value];
            $logic = $request->input("where_logic")[$index];
      
            $condition = ["logic__op"=>$logic,"condition"=>["where_column"=>$where,"operator"=>$operator,"where_value"=>$where_value]];
            $conditions[] = $condition;
        }
        }

        if (!empty($request->input("agrupar_por"))){
            // iterar agrupar[]
            foreach($request->input("agrupar_por") as $index=>$por){
                $agrupar[] = $por;
            }
        }

        $resultados = [
            "nombre_reporte"=>$nombre_reporte,
            "tablas"=>$tablas,
            "columnas"=>$columnas,
            "joins"=>$joins,
            "agregaciones"=>$funciones,
            "condiciones"=>$conditions,
            "agrupar"=>$agrupar
        ];
            


        // Ejecutar query
        $consulta = $this->generarConsulta($resultados);
        $data = $consulta->get();
    
        // Guardar archivo de configuración + Convertir a JSON
        $jsonData = json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        // Guardar en storage/app
        Storage::disk('local')->put('reportes/'.$nombre_reporte.'.json', $jsonData);

        //Guardar reporte
        $Reporte = new Reporte();
        $Reporte->nombre = $nombre_reporte;
        $Reporte->descripcion = $descripcion;
        $Reporte->creadoPor = Auth::user()->id;
        $Reporte->activo = 1;
        $Reporte->save();

        return view('sistema_cobros.reportes.tabla',[
            "title"=>"Tabla",
            "nombre_reporte"=>$nombre_reporte,
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
                $query->where($where['where_column'], $where['operator'], $where['where_value']);
                $firstCondition = false;
            } else {
                if (strtoupper($logicOp) === 'OR') {
                    $query->orWhere($where['where_column'], $where['operator'], $where['where_value']);
                } else {
                    $query->where($where['where_column'], $where['operator'], $where['where_value']);
                }
            }
        }
    }

    // Agregar GROUP BY si existe
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



    public function show(string $id)
    {
        $reporte = Reporte::findOrFail($id);
        $data = Storage::disk('local')->get('reportes/'.$reporte->nombre.'.json');
        $jsonDecoded = json_decode($data, true);
        $consulta = $this->generarConsulta($jsonDecoded);
        $resultados = $consulta->get();

         return view('sistema_cobros.reportes.tabla',[
            "title"=>"Tabla",
            "nombre_reporte"=>$reporte->nombre,
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
        //
    }
}
