<?php
namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class Informes
{


    static public function obtenerConfiguracionSeccion($ruta = "", $id = "") {
        // Verificar que el archivo exista antes de intentar leerlo
        if (!Storage::exists($ruta)) {
            return false;
        }

        $conf = json_decode(Storage::get($ruta), true);

        // Buscar la sección con el ID proporcionado
        foreach ($conf["secciones"] as $seccion) {
            if (isset($seccion["id"]) && $seccion["id"] === $id) {
                // Validación extra para asegurarte de que 'agregados' sea un array
                if (isset($seccion["query"]["agregados"]) && is_string($seccion["query"]["agregados"])) {
                    $seccion["query"]["agregados"] = json_decode($seccion["query"]["agregados"], true);
                }

                return $seccion;
            }
        }

        return false;
    }


    static public function obtenerIndexSeccion($ruta="",$id=""){
        $conf = json_decode(Storage::get($ruta), true);

         if (!Storage::exists($ruta)){
            return false;
         }

         // Buscar la sección con el ID proporcionado
        foreach ($conf["secciones"] as $index=>$seccion) {
            if (isset($seccion["id"]) && $seccion["id"] === $id) {
                return $index;
            }
        }
        return false;
    }

    // Usado en informes/create al momento de enviar el formulario
 static public function estructurarCondiciones(
    array $where,
    array $logicosGrupales = [],
    array $logicosSubgrupo = [],
    array $logicosSimples = [],
    array $orden = []
): array {
    $resultado = [];
    $contadorSimples = 0;

    foreach ($orden as $i => $clave) {
        if (isset($where[$clave])) {
            // Condición simple
            $condicion = $where[$clave];

            if ($contadorSimples > 0 && isset($logicosSimples[$contadorSimples - 1])) {
                $condicion['logico'] = $logicosSimples[$contadorSimples - 1];
            }

            $resultado[] = $condicion;
            $contadorSimples++; // Solo avanzamos el índice si es simple
        } else {
            // Condición grupal
            $grupo = [];

            foreach ($where as $subclave => $condicion) {
                if (str_starts_with($subclave, $clave . '_')) {
                    if (isset($logicosSubgrupo[$subclave])) {
                        $condicion['logico'] = $logicosSubgrupo[$subclave];
                    }
                    $grupo[$subclave] = $condicion;
                }
            }

            if (!empty($grupo)) {
                $bloqueGrupo = ['grupo' => $grupo];

                // Este sí sigue usando $i - 1 porque está en el mismo orden general
                if ($i > 0 && isset($logicosGrupales[$i - 1])) {
                    $bloqueGrupo['logico'] = $logicosGrupales[$i - 1];
                }

                $resultado[] = $bloqueGrupo;
            }
        }
    }

    return $resultado;
}



// Ejemplo para la llamada de esta función
// $data = Informes::ejecutarConsulta($jsonDecoded['configuracion'], [
//     'fecha_inicial' => $request->query('inicio'),
//     'fecha_finaliza' => $request->query('finaliza'),
//     'texto_busqueda' => $request->query('texto'),
// ], 20);

public static function ejecutarConsulta(array $config, array $filtrosExternos = [],int $paginacion = 0)
    {
        // Paso 1: Tabla base
        $tablas = explode(',', $config['tablas_seleccionadas']);
        $query = DB::table($tablas[0]);

        // Paso 2: Joins
        if (!empty($config['joins'])) {
            foreach ($config['joins'] as $join) {
                $query->join($join['tabla_b'], $join['columna_a'], '=', $join['columna_b']);
            }
        }

        // Paso 3: Selección de columnas y agregados juntos
            $columnas = $config['columnas_seleccionadas'] ?? [];
            $selects = [];

            if (!empty($config['agregados'])) {
                foreach ($config['agregados'] as $agregado) {
                    $selects[] = DB::raw("{$agregado['funcion']}({$agregado['columna']}) as {$agregado['alias']}");
                }
            }

            if (!empty($columnas)) {
                foreach ($columnas as $col) {
                    $selects[] = $col;
                }
            }

            if (!empty($selects)) {
                $query->select(...$selects);
            }


        // Paso 4: Where y condiciones
        if (!empty($config['where'])) {
            self::aplicarCondiciones($query, $config['where'], $filtrosExternos);
        }

        // Paso 5: Group By
        if (!empty($config['group_by'])) {
            $query->groupBy($config['group_by']);
        }

        // Paso 6: Order By
        if (!empty($config['order_by'])) {
            foreach ($config['order_by'] as $orden) {
                $query->orderBy($orden['columna'], $orden['direccion'] ?? 'ASC');
            }
        }

        // Paso 7: Límite
        if (!empty($config['limit'])) {
            $query->limit($config['limit']);
        }

        if ($paginacion > 0) {
            return $query->paginate($paginacion);
        }

        if (app()->environment('local')) {
            logger()->info('SQL Debug:', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
        ]);
        }
        if (app()->environment('local')) {
            logger()->info('SQL Debug:', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);
}
        return $query->get();
    }

    protected static function aplicarCondiciones($query, array $where, array $filtrosExternos)
    {
        foreach ($where as $condicion) {
            // Grupos anidados
            if (isset($condicion['grupo'])) {
                $query->where(function ($q) use ($condicion, $filtrosExternos) {
                    foreach ($condicion['grupo'] as $key => $sub) {
                        self::agregarCondicion($q, $sub, $filtrosExternos, $sub['logico'] ?? 'AND');
                    }
                });
            } else {
                self::agregarCondicion($query, $condicion, $filtrosExternos, $condicion['logico'] ?? 'AND');
            }
        }
    }

    protected static function agregarCondicion($query, $condicion, $filtrosExternos, $logico = 'AND')
    {
        $valor = ($condicion['filtro_activo'] === 'true')
            ? ($filtrosExternos[$condicion['filtro_parametro']] ?? null)
            : $condicion['valor'];

         logger()->info('BETWEEN CONDICIÓN:', [
            'parametro' => $condicion['filtro_parametro'],
            'inicio' => $filtrosExternos['fecha_inicial'] ?? null,
            'final' => $filtrosExternos['fecha_finaliza'] ?? null
        ]);
    

        $col = $condicion['columna'];
        $op = strtoupper($condicion['operador']);

        $method = strtolower($logico) === 'or' ? 'orWhere' : 'where';

        // Salta condiciones sin valor si el operador lo requiere
        $operadoresQueRequierenValor = ['=', '!=', '<', '>', '<=', '>=','IN', 'NOT IN', 'BETWEEN'];

        if (in_array($op, $operadoresQueRequierenValor) && is_null($valor)) {
            return; // No aplica la condición si no hay valor
        }
        switch ($op) {
            case 'BETWEEN':
            if ($condicion['filtro_activo'] === 'true') {
                if ($condicion['filtro_parametro'] === 'dos_fechas') {
                    $fechaInicio = $filtrosExternos['fecha_inicial'] ?? null;
                    $fechaFin = $filtrosExternos['fecha_finaliza'] ?? null;

                    if ($fechaInicio && $fechaFin) {
                        $fechaInicio .= ' 00:00:00';
                        $fechaFin .= ' 23:59:59';

                        if (strtolower($logico) === 'or') {
                            $query->orWhereBetween($col, [$fechaInicio, $fechaFin]);
                        } else {
                            $query->whereBetween($col, [$fechaInicio, $fechaFin]);
                        }
                    } elseif ($fechaInicio) {
                        $fechaInicio .= ' 00:00:00';
                        $query->$method($col, '>=', $fechaInicio);
                    } elseif ($fechaFin) {
                        $fechaFin .= ' 23:59:59';
                        $query->$method($col, '<=', $fechaFin);
                    }
                } else {
                    // otro filtro tipo "2025-06-01,2025-06-02"
                    if (is_string($valor)) {
                        $parts = explode(',', $valor);
                        if (count($parts) === 2) {
                            $query->whereBetween($col, [trim($parts[0]), trim($parts[1])]);
                        }
                    }
                }
            } else {
                // Valor manual sin filtro activo
                if (is_string($valor)) {
                    $parts = explode(',', $valor);
                    if (count($parts) === 2) {
                        $query->whereBetween($col, [trim($parts[0]), trim($parts[1])]);
                    }
                }
            }
            break;

            case 'IN':
            case 'NOT IN':
                if (is_string($valor)) {
                    $items = array_map('trim', explode(',', $valor));
                    if ($op === 'IN') {
                        $query->$method(function ($q) use ($col, $items) {
                            $q->whereIn($col, $items);
                        });
                    } else {
                        $query->$method(function ($q) use ($col, $items) {
                            $q->whereNotIn($col, $items);
                        });
                    }
                }
                break;

            case 'IS NULL':
                $query->$method(function ($q) use ($col) {
                    $q->whereNull($col);
                });
                break;

            case 'IS NOT NULL':
                $query->$method(function ($q) use ($col) {
                    $q->whereNotNull($col);
                });
                break;

            case 'LIKE':
            case 'NOT LIKE':
                $pattern = '%' . $valor . '%';
                $query->$method($col, $op, $pattern);
                break;

            default:
                $query->$method($col, $op, $valor);
        }
    }





}
