<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\TablaModulo;
use App\Models\ColumnaTabla;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArtificialIntelligenceController extends Controller
{


    public function iniciarTablasJson(Request $request)
    {

        return view('inteligencia_artificial.carga_tablas', ["title" => "Carga multiple archivo json"]);
    }

    public function guardarTablasJson(Request $request)
    {
        $json = $request->input('contenido'); // Si viene desde editor
        $estructura = json_decode($json, true);

        if (!isset($estructura['tablas']) || !is_array($estructura['tablas'])) {
            return response()->json(['error' => 'Formato JSON inválido o incompleto.'], 400);
        }


        // 1. Se guarda el archivo
        $path = 'ai/conf/temp/tablas_sistema';
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
        Storage::put($path . '/tablas_sistema.json', json_encode($estructura, JSON_PRETTY_PRINT));


        // 2. Se ejecutan los queries de la tabla
        $resultados = [];
        foreach ($estructura['tablas'] as $tabla) {
            $nombreTabla = $tabla['nombre'];
            $query = $tabla['query_instalador'];
            $uuid = (string) Str::uuid();

            try {
                DB::statement($query);

                $resultados[] = [
                    'tabla' => $nombreTabla,
                    'estado' => 'creada',
                    'mensaje' => 'Tabla creada y registrada correctamente'
                ];
            } catch (\Exception $e) {
                Log::error("Error al crear la tabla $nombreTabla: " . $e->getMessage());
                $resultados[] = [
                    'tabla' => $nombreTabla,
                    'estado' => 'error',
                    'mensaje' => $e->getMessage()
                ];
                continue; // No registrar metadatos si falla
            }

            $tablaDB = TablaModulo::create([
                'nombre_tabla' => $nombreTabla,
                'qty_columnas' => count($tabla['nombres_columnas']),
                'creadoPor' => Auth::user()->id, // lo tomas del usuario actual
                'activo' => 1
            ]);

            // Procesar columnas
            $query = $tabla['query_instalador'];
            preg_match('/\((.*)\)/s', $query, $matches);
            $columnasSQL = explode(',', $matches[1]);

            foreach ($columnasSQL as $colRaw) {
                $colRaw = trim($colRaw);
                if (Str::startsWith(strtolower($colRaw), ['foreign', 'primary', 'unique', 'key'])) continue;

                preg_match('/^(\w+)\s+([A-Z]+)(\((\d+)\))?/i', $colRaw, $colMatch);
                $colName = $colMatch[1] ?? null;
                $tipo = strtolower($colMatch[2] ?? 'varchar');
                $longitud = isset($colMatch[4]) ? (int) $colMatch[4] : null;

                if ($colName) {
                    ColumnaTabla::create([
                        'nombre_columna' => $colName,
                        'id_tabla' => $tablaDB->id,
                        'tipo_dato' => $tipo,
                        'qty_caracteres' => $longitud,
                        'es_llave_primaria' => stripos($colRaw, 'primary key') !== false ? 1 : 0,
                        'es_foranea' => stripos($colRaw, 'foreign') !== false ? 1 : 0,
                        'nullable' => stripos($colRaw, 'null') !== false ? 1 : 0,
                        'unica' => stripos($colRaw, 'unique') !== false ? 1 : 0,
                        'activo' => 1
                    ]);
                }
            }
        }

        return response()->json(['resultado' => $resultados]);
    }
}
