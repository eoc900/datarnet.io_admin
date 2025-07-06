<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardsGraphs
{

    // ejemploQuery para 
    public function areaChartQuery($tabla, $columna_agrupacion, $columna_fecha, $segmentar_por = "dia", $tipo_calculo = "suma", $acumulado = false, $rango_fechas = [], $condiciones = [])
    {
        // Definir cómo se agruparán las fechas (por día o mes)
        if ($segmentar_por === "mes") {
            $fecha_formateada = "DATE_FORMAT($columna_fecha, '%Y-%m')"; // Agrupar por mes
        } else { 
            $fecha_formateada = "DATE($columna_fecha)"; // Agrupar por día
        }

        // Definir la operación a realizar
        switch ($tipo_calculo) {
            case "conteo":
                $operacion = "COUNT(*)";
                break;
            case "promedio":
                $operacion = "AVG($columna_agrupacion)";
                break;
            default: // Suma por defecto
                $operacion = "SUM($columna_agrupacion)";
                break;
        }

        // Base del query
        $query = DB::table($tabla)
            ->selectRaw("$fecha_formateada as fecha, $operacion AS valor");

        // Aplicar acumulado con OVER()
        if ($acumulado) {
            $query->selectRaw("SUM($operacion) OVER (ORDER BY $fecha_formateada) AS valor_acumulado");
        }

        $query->groupByRaw($fecha_formateada)
            ->orderByRaw($fecha_formateada);

        // Aplicar filtro por rango de fechas
        if (!empty($rango_fechas)) {
            $query->whereBetween($columna_fecha, [$rango_fechas[0], $rango_fechas[1]]);
        }

        // Aplicar condiciones adicionales
        if (!empty($condiciones)) {
            foreach ($condiciones as $columna => $valor) {
                $query->where($columna, $valor);
            }
        }

        $results = $query->get();
        return $this->areaChart($results->toArray());
         //return ["tabla"=>$tabla,"columna_agrupacion"=>$columna_agrupacion,"fecha_formateada"=>$fecha_formateada,"operacion"=>$operacion,"resultados"=>$results];
    }
  

    public function barChart(array $results): array
    {
        return [
            'labels' => array_column($results, 'categoria'), // Etiquetas de las barras
            'datasets' => [
                [
                    'label' => 'Cantidad',
                    'data' => array_column($results, 'total'), // Valores de las barras
                ]
            ]
        ];
    }


    public function lineChart(array $results): array
    {
        return [
            'labels' => array_column($results, 'fecha'), // Fechas en el eje X
            'datasets' => [
                [
                    'label' => 'Tendencia',
                    'data' => array_column($results, 'valor'), // Valores en el eje Y
                ]
            ]
        ];
    }


    public function pieChart(array $results): array
    {
        return [
            'labels' => array_column($results, 'categoria'), // Categorías
            'datasets' => [
                [
                    'data' => array_column($results, 'porcentaje'), // Valores porcentuales
                ]
            ]
        ];
    }


    public function areaChart(array $results): array
    {
        return [
            'labels' => array_column($results, 'fecha'), // Fechas en el eje X
            'datasets' => [
                [
                    'label' => 'Acumulado',
                    'data' => (array_column($results, 'valor_acumulado'))?array_column($results, 'valor_acumulado'):array_column($results, 'valor'), // Valores acumulados en el eje Y
                ]
            ]
        ];
    }


    public static function tableData(array $results): array
    {
        return [
            'headers' => array_keys($results[0] ?? []), // Encabezados de la tabla
            'rows' => $results // Filas de la tabla con datos completos
        ];
    }
    public function areaChartExample(){
        $areaChartResults = [
            ['fecha' => '2024-02-01', 'valor_acumulado' => 100],
            ['fecha' => '2024-02-02', 'valor_acumulado' => 220],
            ['fecha' => '2024-02-03', 'valor_acumulado' => 310],
            ['fecha' => '2024-02-04', 'valor_acumulado' => 440],
            ['fecha' => '2024-02-05', 'valor_acumulado' => 550],
        ];
        $results = $this->areaChart($areaChartResults);
        return $results;
    }
    public function pieChartExample(){
       $pieChartResults = [
            ['categoria' => 'Ventas', 'porcentaje' => 40],
            ['categoria' => 'Marketing', 'porcentaje' => 25],
            ['categoria' => 'Producción', 'porcentaje' => 15],
            ['categoria' => 'Logística', 'porcentaje' => 10],
            ['categoria' => 'Otros', 'porcentaje' => 10],
        ];
        $results = $this->pieChart($pieChartResults);
        return $results;
    }
    public function lineChartExample(){
       $lineChartResults = [
            ['fecha' => '2024-02-01', 'valor' => 100],
            ['fecha' => '2024-02-02', 'valor' => 120],
            ['fecha' => '2024-02-03', 'valor' => 90],
            ['fecha' => '2024-02-04', 'valor' => 130],
            ['fecha' => '2024-02-05', 'valor' => 110],
        ];
        $results = $this->lineChart($lineChartResults);
        return $results;
    }
    public function barChartExample(){
        $barChartResults = [
            ['categoria' => 'Enero', 'total' => 150],
            ['categoria' => 'Febrero', 'total' => 200],
            ['categoria' => 'Marzo', 'total' => 180],
            ['categoria' => 'Abril', 'total' => 220],
            ['categoria' => 'Mayo', 'total' => 170],
        ];
        $results = $this->barChart($barChartResults);
        return $results;
    }
    public function getExampleResult($chart){
        // Llamamos para visualizar cómo deben de verse los datos
        $chart = Str::lower($chart);
        if($chart=="line_chart" || $chart=="linechart"){
            return $this->lineChartExample();
        }
        if($chart=="area_chart" || $chart=="areachart"){
            return $this->areaChartExample();
        }
        if($chart=="bar_chart" || $chart=="barchart"){
            return $this->barChartExample();
        }
        if($chart=="pie_chart" || $chart=="piechart"){
            return $this->pieChartExample();
        }
        return false;
    }

    public function consultaFormatoGrafico($sql_json, $tipo_grafica, $meta = []) {
        if ($tipo_grafica == "linechart") {
            $columna_group = 'fecha';
            $ag_as = "valor";
        } elseif ($tipo_grafica == "areachart") {
            $columna_group = 'fecha';
            $ag_as = "valor_acumulado";
        } elseif ($tipo_grafica == "barchart") {
            $columna_group = 'categoria';
            $ag_as = "total";
        } elseif ($tipo_grafica == "piechart") {
            $columna_group = 'categoria';
            $ag_as = "porcentaje";
        }

        $query = DB::table($sql_json['tablas'][0]);

        // V1
        //columnas = [];
        // $columnas[] = $sql_json['columnas'][0] . " as " . $columna_group;

        if(!isset($sql_json["agrupar"]['es_fecha'])){
            $columnas = [];
            $columnas[] = $sql_json['columnas'][0] . " as " . $columna_group;
        }else{
            $columnas = [];
        }
        
    
        if (!empty($sql_json['agregaciones'])) {
            foreach ($sql_json['agregaciones'] as $agregacion) {
                $columnas[] = DB::raw("{$agregacion['funcion']}({$agregacion['columna']}) AS {$ag_as}");
            }
        }

        // V2 Verificar si hay un 'agrupar_por' con fecha y distribución por día, semana o mes
        if (!empty($sql_json['agrupar'])) {
             \Log::info("agrupar no está vacío");
            $agrupar = $sql_json['agrupar'];
            
            if (isset($agrupar['es_fecha']) && $agrupar['es_fecha']) {
                $columna = $agrupar['columna'];
                // Filtrar el arreglo y eliminar el elemento que coincida con $columna
                $columnas = array_filter($columnas, function($item) use ($columna) {
                    return $item !== $columna;
                });
                $tipo = $agrupar['distribuido_por'] ?? 'dia';

                switch ($tipo) {
                 
                    case 'mes':
                           \Log::info("distribuido por mes");
                        $columnas[] = DB::raw("YEAR($columna) as anio, MONTH($columna) as fecha");
                        $query->groupByRaw("YEAR($columna), MONTH($columna)");
                        $query->orderBy($columna_group,"asc");
                        break;

                    case 'semana':
                        $columnas[] = DB::raw("YEAR($columna) as anio, WEEK($columna) as fecha");
                        $query->groupByRaw("YEAR($columna), WEEK($columna)");
                        $query->orderBy($columna_group,"asc");
                        break;

                    case 'dia':
                        $columnas[] = DB::raw("DATE($columna) as fecha");
                        $query->groupByRaw("DATE($columna)");
                        $query->orderBy($columna_group,"asc");
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


        if (!empty($columnas)) {
            $query->select($columnas);
        }

        if (!empty($sql_json['joins'])) {
            foreach ($sql_json['joins'] as $join) {
                $tipoJoin = $join['joinType'] === 'leftJoin' ? 'leftJoin' : 'join';
                $query->$tipoJoin($join['tabla'], function ($joinClause) use ($join) {
                    $joinClause->on($join['on'][0], $join['on'][1], $join['on'][2]);
                });
            }
        }

        if (!empty($sql_json['condiciones'])) {
            $firstCondition = true;
            foreach ($sql_json['condiciones'] as $condicion) {
                $logicOp = $condicion['logic__op'] ?? '';
                $where = $condicion['condition'];

                if ($firstCondition) {
                    if ($where['operator'] == "between") {
                        $query->whereBetween($where['where_column'], [$where['where_value'][0], $where['where_value'][1]]);
                    } else {
                        $query->where($where['where_column'], $where['operator'], $where['where_value']);
                        $firstCondition = false;
                    }
                } else {
                    if (strtoupper($logicOp) === 'OR') {
                        if ($where['operator'] == "between") {
                            $query->orWhereBetween($where['where_column'], [$where['where_value'][0], $where['where_value'][1]]);
                        } else {
                            $query->orWhere($where['where_column'], $where['operator'], $where['where_value']);
                        }
                    } else {
                        $query->where($where['where_column'], $where['operator'], $where['where_value']);
                    }
                }
            }
        }

         // Nueva implementación 'agrupar_por'=>['columna'=>"inscripciones.fecha_inicio","es_fecha"=>true,"distribuido_por"=>["dia","semana","mes"]]
        
     
        if (!empty($sql_json['agrupar']) && !isset($sql_json["agrupar"]['es_fecha'])) {
             $query->groupBy($sql_json['agrupar']);
        }

        if (!empty($sql_json['ordenar'])) {
            foreach ($sql_json['ordenar'] as $orden) {
                $query->orderBy($orden['columna'], $orden['direccion'] ?? 'asc');
            }
        }
        \Log::info($query->toSql());
        $result = $query->get();

        if ($tipo_grafica === 'pie_chart') {
            $totalRegistros = $result->sum('porcentaje');
            $result = $result->map(function ($item) use ($totalRegistros) {
                return [
                    'categoria' => $item->categoria,
                    'porcentaje' => round(($item->porcentaje / $totalRegistros) * 100, 2)
                ];
            });
        }

        //return $result->toArray();  

        $chart = Str::lower($tipo_grafica);
        if($chart=="line_chart" || $chart=="linechart"){
            return $this->lineChart($result->toArray());
        }
        if($chart=="area_chart" || $chart=="areachart"){
            return $this->areaChart($result->toArray());
        }
        if($chart=="bar_chart" || $chart=="barchart"){
            return $this->barChart($result->toArray());
        }
        if($chart=="pie_chart" || $chart=="piechart"){
            return $this->pieChart($result->toArray());
        }
    }


    public static function loadInFrontEnd(){
        
    }
}
