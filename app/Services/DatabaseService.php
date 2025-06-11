<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\JsonResponse; // Asegúrate de importar esto

class DatabaseService
{
    public static function obtenerTablasConPrefijo(string $prefijo)
    {
        // Obtener el listado de todas las tablas
        $tablas = DB::select("SHOW TABLES");

        // Nombre de la columna devuelta por SHOW TABLES (depende del motor)
        $key = "Tables_in_" . env('DB_DATABASE');

        // Filtrar tablas que comiencen con el prefijo
        $tablasFiltradas = array_filter(array_column($tablas, $key), function ($tabla) use ($prefijo) {
            return str_starts_with($tabla, $prefijo);
        });

        return array_values($tablasFiltradas); // Resetear índices del array
    }


        public static function obtenerTablasParaSelect2(string $search = null): JsonResponse
        {
                $prefijo = 'modulo_'; // Prefijo fijo para filtrar tablas
                $search = $search ?? ''; // Asegurar que $search no sea null

                // Obtener el listado de todas las tablas
                $tablas = DB::select("SHOW TABLES");

                // Nombre de la columna devuelta por SHOW TABLES (depende del motor de BD)
                $dbName = env('DB_DATABASE');
                $key = "Tables_in_{$dbName}";

                // Filtrar tablas que comiencen con el prefijo y coincidan con la búsqueda
                $tablasFiltradas = array_filter(array_column($tablas, $key), function ($tabla) use ($prefijo, $search) {
                    return str_starts_with($tabla, $prefijo) && ($search === '' || stripos($tabla, $search) !== false);
                });

                // Convertir en formato compatible con Select2
                $resultados = array_map(function ($tabla) use ($prefijo) {
                    return [
                        'id' => $tabla,  
                        'text' => ucfirst(str_replace('_', ' ', str_replace($prefijo, '', $tabla))) 
                    ];
                }, array_values($tablasFiltradas));

                return response()->json(['results' => $resultados]);
        }



    public static function obtenerColumnasDeTabla(string $tabla, $except = [])
    {
        $columnas = Schema::getColumnListing($tabla);
        return array_values(array_diff($columnas, $except));
    }

    public static function obtenerColumnasTipoDato(string $tabla)
    {
        // Obtener información de las columnas de la tabla
        $columnas = DB::select("SHOW COLUMNS FROM {$tabla}");

        // Filtrar y formatear la información, excluyendo 'created_at' y 'updated_at'
        $resultado = array_map(function ($columna) {
            return [
                'nombre' => $columna->Field, // Nombre de la columna
                'tipo' => $columna->Type,    // Tipo de dato (Ej: varchar(255), int, date, etc.)
            ];
        }, array_filter($columnas, function ($columna) {
            return !in_array($columna->Field, ['created_at', 'updated_at','id']);
        }));

        return $resultado;
    }


}
