<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class InstaladorController extends Controller
{
    public function formularioSQL()
    {
        return view('sistema_cobros.instalador.cargar_sql', [
            "title" => "Instalación sql"
        ]);
    }

    public function importarSQL(Request $request)
    {
        $orden = json_decode($request->input('orden_archivos', '[]'), true);
        $archivos = $request->file('archivos_sql', []);
        $sobrescribir = $request->has('sobrescribir'); // true o false


        if (!$archivos || empty($orden)) {
            return back()->with('error', 'No se recibieron archivos o no se seleccionó orden de ejecución.');
        }

        // Mapeo por nombre de archivo
        $mapa = [];
        foreach ($archivos as $archivo) {
            $mapa[$archivo->getClientOriginalName()] = $archivo;
        }

        foreach ($orden as $nombreArchivo) {
            if (!isset($mapa[$nombreArchivo])) continue;

            $contenido = File::get($mapa[$nombreArchivo]->getRealPath());
            $resultado = $this->procesarSQL(File::get($mapa[$nombreArchivo]->getRealPath()), $nombreArchivo, $sobrescribir);

            if ($resultado !== true) {
                return back()->with('error', $resultado);
            }
        }

        return back()->with('success', 'Archivos ejecutados correctamente.');
    }

  private function procesarSQL($contenido, $nombreArchivo = '', $sobrescribir = false)
{
    $bloques = array_filter(array_map('trim', explode(';', $contenido)));
    $createStatements = [];
    $otrosStatements = [];

    foreach ($bloques as $bloque) {
        $sql = trim($bloque);

        if (empty($sql) || preg_match('/^--/', $sql)) continue;

        // Detectar si contiene un CREATE TABLE
        if (preg_match('/create\s+table\s+`?([a-zA-Z0-9_]+)`?/i', $sql, $match)) {
            $tabla = $match[1];

            if (Schema::hasTable($tabla)) {
                if ($sobrescribir) {
                    try {
                        DB::statement("DROP TABLE IF EXISTS `$tabla`");
                    } catch (\Exception $e) {
                        return "Error al intentar eliminar la tabla '$tabla' en '$nombreArchivo': " . $e->getMessage();
                    }
                } else {
                    continue; // No sobrescribir
                }
            }

            $createStatements[] = ['tabla' => $tabla, 'sql' => $sql];
            continue;
        }

        $otrosStatements[] = $sql;
    }

    foreach ($createStatements as $c) {
        try {
            DB::unprepared($c['sql'] . ';');
        } catch (\Exception $e) {
            return "Error al crear tabla '{$c['tabla']}' en archivo '$nombreArchivo': " . $e->getMessage();
        }
    }

    foreach ($otrosStatements as $sql) {
        if (Str::startsWith(strtolower($sql), 'insert into')) {
            $sql = preg_replace('/insert into/i', 'INSERT IGNORE INTO', $sql);
        }

        try {
            DB::unprepared($sql . ';');
        } catch (\Exception $e) {
            return "Error en archivo '$nombreArchivo': " . $e->getMessage();
        }
    }

    return true;
}






}
