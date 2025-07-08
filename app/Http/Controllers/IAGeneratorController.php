<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;
use App\Models\TablaModulo;
use App\Models\ColumnaTabla;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;



class IAGeneratorController extends Controller
{
    protected $systemPromptPhase1 = [
        'role' => 'system',
        'content' => <<<EOT
            Eres un asistente experto en diseño de bases de datos con Laravel.
            Siempre debes responder en formato JSON.

            Vas a utilizar la estructura de los siguientes modelos para adaptarlos a las tablas que vas a generar: 
            {
            "model_tabla_modulo": {
                "id": { "Type": "bigint unsigned", "Null": "NO", "Key": "PRI", "Default": "NULL", "Extra": "auto_increment" },
                "nombre_tabla": { "Type": "varchar(255)", "Null": "NO", "Key": "", "Default": "NULL", "Extra": "" },
                "qty_columnas": { "Type": "int", "Null": "YES", "Key": "", "Default": "NULL", "Extra": "" },
                "creadoPor": { "Type": "char(36)", "Null": "NO", "Key": "", "Default": "NULL", "Extra": "" },
                "activo": { "Type": "tinyint(1)", "Null": "NO", "Key": "", "Default": "NULL", "Extra": "" },
                "created_at": { "Type": "timestamp", "Null": "YES", "Key": "", "Default": "NULL", "Extra": "" },
                "updated_at": { "Type": "timestamp", "Null": "YES", "Key": "", "Default": "NULL", "Extra": "" }
            },
            "model_columna_tabla": {
                "id": { "Type": "bigint unsigned", "Null": "NO", "Key": "PRI", "Default": "NULL", "Extra": "auto_increment" },
                "nombre_columna": { "Type": "varchar(62)", "Null": "NO", "Key": "", "Default": "NULL", "Extra": "" },
                "id_tabla": { "Type": "bigint unsigned", "Null": "NO", "Key": "", "Default": "NULL", "Extra": "" },
                "tipo_dato": { "Type": "varchar(32)", "Null": "NO", "Key": "", "Default": "NULL", "Extra": "" },
                "qty_caracteres": { "Type": "tinyint unsigned", "Null": "YES", "Key": "", "Default": "NULL", "Extra": "" },
                "es_llave_primaria": { "Type": "tinyint(1)", "Null": "NO", "Key": "", "Default": "0", "Extra": "" },
                "es_foranea": { "Type": "tinyint(1)", "Null": "NO", "Key": "", "Default": "0", "Extra": "" },
                "on_table": { "Type": "varchar(255)", "Null": "YES", "Key": "", "Default": "NULL", "Extra": "" },
                "on_column": { "Type": "varchar(255)", "Null": "YES", "Key": "", "Default": "NULL", "Extra": "" },
                "nullable": { "Type": "tinyint(1)", "Null": "NO", "Key": "", "Default": "NULL", "Extra": "" },
                "activo": { "Type": "tinyint(1)", "Null": "NO", "Key": "", "Default": "NULL", "Extra": "" },
                "unica": { "Type": "tinyint(1)", "Null": "NO", "Key": "", "Default": "0", "Extra": "" },
                "created_at": { "Type": "timestamp", "Null": "YES", "Key": "", "Default": "NULL", "Extra": "" },
                "updated_at": { "Type": "timestamp", "Null": "YES", "Key": "", "Default": "NULL", "Extra": "" }
            },
            "tablas": [
                {
                "nombre": "modulo_pagos",
                "nombres_columnas": [
                    "id",
                    "id_alumno",
                    "fecha_pago",
                    "monto_total",
                    "periodo_pago",
                    "referencia_pago",
                    "id_tipo_pago",
                    "id_estatus_pago",
                    "created_at",
                    "updated_at"
                ],
                "query_instalador": "CREATE TABLE modulo_pagos (id BIGINT AUTO_INCREMENT PRIMARY KEY, id_alumno BIGINT, fecha_pago DATE, monto_total DECIMAL(10,2), periodo_pago VARCHAR(32), referencia_pago VARCHAR(64), id_tipo_pago BIGINT, id_estatus_pago BIGINT, created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, FOREIGN KEY (id_alumno) REFERENCES modulo_alumnos(id));",
                "TablaModulo": {
                    "nombre_tabla": "modulo_pagos",
                    "qty_columnas": 9,
                    "creadoPor": "uuid-del-usuario",
                    "activo": 1
                },
                "ColumnaTabla": [
                    {
                    "nombre_columna": "id",
                    "tipo_dato": "bigint",
                    "es_llave_primaria": 1,
                    "es_foranea": 0,
                    "nullable": 0,
                    "activo": 1
                    },
                    {
                    "nombre_columna": "matricula",
                    "tipo_dato": "varchar(32)",
                    "es_llave_primaria": 0,
                    "unica": 1,
                    "nullable": 0,
                    "activo": 1
                    }
                    // Nota: continúa la definición de columnas según el caso
                ]
                }
            ]
            }

            Reglas obligatorias:

            1. Utiliza únicamente el comando CREATE TABLE en "query_instalador".
            2. Las tablas deben estar ordenadas jerárquicamente según sus dependencias (tablas sin llaves foráneas primero).
            3. Si una columna parece enum, crea una tabla nueva con los valores posibles. No uses tipo enum.
            4. Todas las llaves primarias se llaman 'id'.
            5. Llaves foráneas deben llamarse 'id_' seguido del nombre de la tabla referenciada.
            6. Tipos de datos válidos: bigint, int, varchar(n), text, date, datetime, boolean, decimal(10,2), timestamp.
            7. Los nombres de columna deben estar en snake_case y ser únicos dentro de cada tabla.
            8. El nombre de cada tabla debe empezar con el prefijo 'modulo_'.
            9. El campo 'creadoPor' debe tener el valor: "uuid-del-usuario" (será reemplazado por Laravel).
            10. Si no puedes cumplir alguna regla, responde con: { "error": "Mensaje descriptivo" }
            11. No uses bloques de código ni json en la respuesta. Solo devuelve el objeto JSON directamente
            12. Por favor no metas comentarios, sólo retorna json puro
            EOT
    ];




    public function generarJson(Request $request)
    {
        $prompt = $request->input('prompt');

        if (!$prompt) {
            return response()->json(['error' => 'No se proporcionó prompt'], 400);
        }

        try {
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o',
                'messages' => [
                    $this->systemPromptPhase1,
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $content = $response->choices[0]->message->content;

            // Limpiar etiquetas Markdown (```json ... ```)
            $content = preg_replace('/^```json\s*/', '', $content); // elimina ```json al inicio
            $content = preg_replace('/```$/', '', $content);        // elimina ``` al final
            $content = trim($content);

            $jsonDecoded = json_decode($content, true);


            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'error' => 'La respuesta de la IA no es un JSON válido.',
                    'raw_content' => $content
                ], 422);
            }

            // Asegurar que exista la carpeta
            $path = 'estructuras';
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path);
            }

            // Generar nombre de archivo basado en fecha y slug del prompt
            $slug = Str::slug(Str::limit($prompt, 50));
            $filename = now()->format('Ymd_His') . '_' . $slug . '.json';

            // Guardar archivo JSON con formato legible
            Storage::put($path . '/' . $filename, json_encode($jsonDecoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return response()->json([
                'mensaje' => 'Estructura generada y guardada correctamente.',
                'archivo' => $filename,
                'respuesta' => $jsonDecoded,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al generar respuesta de IA',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    // Vista asistente experto
    public function asistenteExpertoDB()
    {
        return view('inteligencia_artificial.asistente_experto_db', ["title" => "Asistente experto"]);
    }

    // Vista cargar tablas via formato json
    public function cargarTablasDB()
    {
        return view('inteligencia_artificial.carga_directa_db', ["title" => "Realizar carga"]);
    }

    public function generar(Request $request)
    {
        $prompt = $request->input('prompt_original');

        if (!$prompt) {
            return back()->with('error', 'No se proporcionó descripción.');
        }

        try {
            Log::info('[IA] Prompt enviado por usuario:', ['prompt' => $prompt]);

            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o',
                'messages' => [
                    $this->systemPromptPhase1,
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $content = trim(preg_replace(['/^```json\s*/', '/```$/'], '', $response->choices[0]->message->content));
            Log::info('[IA] Respuesta cruda recibida:', ['content' => $content]);

            $jsonDecoded = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::warning('[IA] JSON inválido en respuesta.', ['error' => json_last_error_msg()]);
                return back()->with('error', 'La IA no devolvió un JSON válido.')->withInput();
            }

            Log::info('[IA] JSON decodificado exitosamente.');

            return back()->with('json', $jsonDecoded)->with('prompt', $prompt);
        } catch (\Exception $e) {
            Log::error('[IA] Error en generación:', ['exception' => $e->getMessage()]);
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function complementar(Request $request)
    {
        $promptOriginal = $request->input('prompt_original_hidden');
        $jsonOriginal = $request->input('json_original_hidden');
        $sugerencia = $request->input('sugerencia_usuario');

        if (!$promptOriginal || !$jsonOriginal || !$sugerencia) {
            Log::warning('[IA] Faltan datos para generar la sugerencia.', [
                'prompt_original' => $promptOriginal,
                'json_original' => $jsonOriginal,
                'sugerencia' => $sugerencia,
            ]);

            return back()->with('error', 'Faltan datos para generar la sugerencia.');
        }

        $promptCompuesto = <<<EOT
        Este fue el prompt original que el usuario envió:
        """
        $promptOriginal
        """

        Este fue el JSON generado por la IA:
        """
        $jsonOriginal
        """

        El usuario solicita los siguientes cambios o extensiones:
        """
        $sugerencia
        """

        Por favor, genera una nueva versión del JSON cumpliendo con la estructura y reglas del sistema.
        EOT;

        try {
            Log::info('[IA] Prompt compuesto para mejora generado.', ['prompt_completo' => $promptCompuesto]);

            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o',
                'messages' => [
                    $this->systemPromptPhase1,
                    ['role' => 'user', 'content' => $promptCompuesto],
                ],
            ]);

            $content = trim(preg_replace(['/^```json\s*/', '/```$/'], '', $response->choices[0]->message->content));
            Log::info('[IA] Respuesta cruda recibida en mejora:', ['content' => $content]);

            $jsonDecoded = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::warning('[IA] JSON inválido en respuesta a mejora.', [
                    'error' => json_last_error_msg(),
                    'respuesta_cruda' => $content,
                ]);

                return back()
                    ->with('error', 'La IA no devolvió un JSON válido.')
                    ->with('prompt', $promptOriginal)
                    ->with('json', json_decode($jsonOriginal, true));
            }

            Log::info('[IA] JSON modificado generado con éxito.');
            return back()->with('json', $jsonDecoded)->with('prompt', $promptOriginal);
        } catch (\Exception $e) {
            Log::error('[IA] Error en mejora de estructura IA.', ['exception' => $e->getMessage()]);
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    // APROBADA: Al momento de realizar los cambios y aprobarlos en cuanto a la fase de asistente experto en base de datos

    public function aprobarF1(Request $request)
    {
        $json = $request->input('estructura');
        if (!$json) {
            return response()->json(['error' => 'No se proporcionó estructura.'], 400);
        }

        $estructura_raw = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($estructura_raw['tablas'])) {
            return response()->json(['error' => 'El JSON es inválido o está incompleto.'], 422);
        }

        // Validar que no haya nombres de tabla duplicados
        $nombreTablas = [];
        foreach ($estructura_raw['tablas'] as $t) {
            preg_match('/CREATE TABLE\s+(\w+)/i', $t['query_instalador'], $match);
            $nombre = $match[1] ?? null;
            if ($nombre && in_array($nombre, $nombreTablas)) {
                return response()->json(['error' => "Tabla duplicada detectada en el JSON: {$nombre}"], 422);
            }
            $nombreTablas[] = $nombre;
        }

        // Transformar estructura
        $estructura = $this->procesarQueriesInstaladoresAvanzado($estructura_raw);

        $tablasExistentes = [];

        try {
            DB::beginTransaction();

            foreach ($estructura_raw['tablas'] as $i => $tabla_raw) {
                $nombreTabla = $estructura[$i]['TablaModulo']['nombre_tabla'];

                if (Schema::hasTable($nombreTabla)) {
                    $tablasExistentes[] = $nombreTabla;
                    continue;
                }

                try {
                    Log::info("Creando tabla: {$nombreTabla}");
                    DB::statement($tabla_raw['query_instalador']);
                } catch (\Throwable $ex) {
                    if (DB::transactionLevel() > 0) {
                        DB::rollBack();
                    }

                    // Mostrar error exacto al navegador
                    return response()->json([
                        'error' => '❌ Error al ejecutar el query para la tabla `' . $nombreTabla . '`',
                        'query' => $tabla_raw['query_instalador'],
                        'sql_error' => $ex->getMessage()
                    ], 500);
                }


                try {
                    // Insertar en tabla_modulo
                    $metaTabla = $estructura[$i]['TablaModulo'];
                    $tablaDB = new TablaModulo();
                    $tablaDB->nombre_tabla = $metaTabla['nombre_tabla'];
                    $tablaDB->qty_columnas = $metaTabla['qty_columnas'];
                    $tablaDB->creadoPor = $metaTabla['creadoPor'];
                    $tablaDB->activo = $metaTabla['activo'];
                    $tablaDB->save();

                    $id_tabla = $tablaDB->id;

                    // Insertar columnas
                    foreach ($estructura[$i]['ColumnaTabla'] as $col) {
                        $columna = new ColumnaTabla();
                        $columna->nombre_columna = $col['nombre_columna'];
                        $columna->id_tabla = $id_tabla;
                        $columna->tipo_dato = $col['tipo_dato'];
                        $columna->qty_caracteres = $col['qty_caracteres'] ?? null;
                        $columna->es_llave_primaria = $col['es_llave_primaria'];
                        $columna->es_foranea = $col['es_foranea'];
                        $columna->nullable = $col['nullable'];
                        $columna->activo = $col['activo'];
                        $columna->unica = $col['unica'] ?? 0;
                        $columna->on_table = $col['on_table'] ?? null;
                        $columna->on_column = $col['on_column'] ?? null;
                        $columna->save();
                    }
                } catch (\Throwable $ex) {
                    if (DB::transactionLevel() > 0) {
                        DB::rollBack();
                    }

                    return response()->json([
                        'error' => "❌ Error al guardar metadatos para la tabla `{$nombreTabla}`",
                        'exception' => $ex->getMessage()
                    ], 500);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', [
                'mensaje' => 'Estructura aplicada correctamente.',
                'tablas_existentes' => $tablasExistentes,
            ]);
        } catch (\Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            Log::error('[IA.aprobar] Error al aplicar estructura', [
                'error' => $e->getMessage(),
                'json' => $estructura_raw ?? null
            ]);

            return response()->json([
                'error' => 'Error al aplicar estructura. ' . $e->getMessage()
            ], 500);
        }
    }




    function procesarQueriesInstaladoresAvanzado(array $data)
    {
        $resultado = [];

        foreach ($data['tablas'] as $item) {
            $query = $item['query_instalador'];

            preg_match('/CREATE TABLE\s+(\w+)/i', $query, $matchTabla);
            $nombre_tabla = $matchTabla[1] ?? null;

            preg_match('/\((.*)\)/s', $query, $matchColumnas);
            $columnas_texto = $matchColumnas[1] ?? null;

            if (!$nombre_tabla || !$columnas_texto) continue;

            $lineas_raw = preg_split('/,(?![^(]*\))/', $columnas_texto);
            $lineas = array_map('trim', $lineas_raw);

            $foraneas = [];
            foreach ($lineas as $linea) {
                if (stripos($linea, 'FOREIGN KEY') !== false) {
                    preg_match('/FOREIGN KEY\s*\((\w+)\)\s*REFERENCES\s*(\w+)\s*\((\w+)\)/i', $linea, $matches);
                    if ($matches) {
                        $foraneas[strtolower($matches[1])] = [
                            'on_table' => $matches[2],
                            'on_column' => $matches[3]
                        ];
                    }
                }
            }

            $columnas = [];
            foreach ($lineas as $linea) {
                if (stripos($linea, 'FOREIGN KEY') !== false || stripos($linea, 'CONSTRAINT') !== false) {
                    continue;
                }

                preg_match('/^(\w+)\s+([A-Z]+(?:\(\d+(?:,\d+)?\))?)/i', $linea, $parts);
                $nombre_columna = $parts[1] ?? null;
                $tipo_dato = strtolower($parts[2] ?? '');

                if (!$nombre_columna) continue;

                preg_match('/\((\d+)(?:,(\d+))?\)/', $tipo_dato, $sizeMatch);
                $qty_caracteres = isset($sizeMatch[1]) ? (int)$sizeMatch[1] : null;

                $tipo_base = preg_replace('/\(\d+(?:,\d+)?\)/', '', $tipo_dato);

                $columnas[] = [
                    'nombre_columna' => $nombre_columna,
                    'tipo_dato' => $tipo_base,
                    'qty_caracteres' => $qty_caracteres,
                    'es_llave_primaria' => stripos($linea, 'PRIMARY KEY') !== false ? 1 : 0,
                    'es_foranea' => array_key_exists(strtolower($nombre_columna), $foraneas) ? 1 : 0,
                    'on_table' => $foraneas[strtolower($nombre_columna)]['on_table'] ?? null,
                    'on_column' => $foraneas[strtolower($nombre_columna)]['on_column'] ?? null,
                    'nullable' => stripos($linea, 'NOT NULL') === false ? 1 : 0,
                    'activo' => 1,
                    'unica' => stripos($linea, 'UNIQUE') !== false ? 1 : 0,
                    'created_at' => null,
                    'updated_at' => null
                ];
            }

            $resultado[] = [
                'TablaModulo' => [
                    'nombre_tabla' => $nombre_tabla,
                    'qty_columnas' => count(array_filter($columnas, fn($c) => !in_array($c['nombre_columna'], ['created_at', 'updated_at']))),
                    'creadoPor' => Auth::user()->id,
                    'activo' => 1
                ],
                'ColumnaTabla' => $columnas
            ];
        }

        return $resultado;
    }
}
