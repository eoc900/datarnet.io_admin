<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class RespaldosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sistema_cobros.respaldos.create',["title"=>"Crear respaldo"]);
    }


    public function generar(Request $request)
    {
        $seleccionados = $request->input('respaldo', []);
        $zipFile = storage_path('app/respaldo_' . now()->format('Ymd_His') . '.zip');
        $tempDir = storage_path('app/temp_respaldo');

        // Limpiar y crear directorio temporal
        if (File::exists($tempDir)) File::deleteDirectory($tempDir);
        File::makeDirectory($tempDir);

        foreach ($seleccionados as $item) {
            match ($item) {
                'informes' => $this->copiarCarpeta('informes', $tempDir),
                'formularios' => $this->copiarCarpeta('formularios', $tempDir),
                'banners' => $this->copiarCarpeta('banners_formularios', $tempDir),
                'archivos' => $this->copiarSubcarpetas('archivos', $tempDir),
                'tablas' => $this->exportarTablas($tempDir),
                default => null,
            };
        }

        // Crear archivo ZIP
        $zip = new ZipArchive();
        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($tempDir),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = Str::after($filePath, $tempDir . '/');
                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();
        }

        File::deleteDirectory($tempDir);
        return response()->download($zipFile)->deleteFileAfterSend(true);
    }

    private function copiarCarpeta($nombreCarpeta, $tempDir)
    {
        $origen = storage_path("app/$nombreCarpeta");
        $destino = "$tempDir/$nombreCarpeta";
        if (File::exists($origen)) {
            File::copyDirectory($origen, $destino);
        }
    }

    private function copiarSubcarpetas($carpetaBase, $tempDir)
    {
        $origen = storage_path("app/$carpetaBase");
        $destino = "$tempDir/$carpetaBase";
        File::makeDirectory($destino);
        $subcarpetas = File::directories($origen);

        foreach ($subcarpetas as $sub) {
            $subNombre = basename($sub);
            File::copyDirectory($sub, "$destino/$subNombre");
        }
    }

   private function exportarTablas($tempDir)
{
    $ruta = "$tempDir/tablas";
    File::ensureDirectoryExists($ruta);

    $tablasFijas = [
        'form_creator', 'informes', 'tablas_modulos', 'tipos_datos',
        'ligas_formularios', 'columnas_tablas', 'archivos',
        'model_has_permissions', 'model_has_roles', 'role_has_permissions',
        'roles', 'permissions','users'
    ];

    $todasLasTablas = DB::select('SHOW TABLES');
    $nombreColumna = 'Tables_in_' . DB::getDatabaseName();

    $moduloTablas = collect($todasLasTablas)
        ->pluck($nombreColumna)
        ->filter(fn($tabla) => str_starts_with($tabla, 'modulo_'))
        ->toArray();

    $tablas = array_merge($tablasFijas, $moduloTablas);

    foreach ($tablas as $tabla) {
        if (!Schema::hasTable($tabla)) continue;

        $estructura = DB::select("SHOW CREATE TABLE `$tabla`")[0]->{'Create Table'};
        $datos = DB::table($tabla)->get();

        $sql = $estructura . ";\n\n";

        foreach ($datos as $fila) {
            $columnas = array_map(fn($v) => "`$v`", array_keys((array) $fila));
            $valores = array_map(function ($v) {
                if ($v === null) return "NULL";
                return "'" . addslashes($v) . "'";
            }, array_values((array) $fila));

            $sql .= "INSERT INTO `$tabla` (" . implode(',', $columnas) . ") VALUES (" . implode(',', $valores) . ");\n";
        }

        File::put("$ruta/{$tabla}.sql", $sql);
    }
}





    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
