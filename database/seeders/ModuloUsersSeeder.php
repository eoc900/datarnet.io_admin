<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ModuloUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Insertar tabla en tablas_modulos
        $tablaId = DB::table('tablas_modulos')->insertGetId([
            'nombre_tabla' => 'modulo_users',
            'qty_columnas' => 4,
            'creadoPor' => '00000000-0000-0000-0000-000000000000', // ID del instalador
            'activo' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Insertar columnas
        $columnas = [
            ['nombre_columna' => 'uuid_repetido', 'tipo_dato' => 'char(36)', 'es_llave_primaria' => 1, 'unica' => 1],
            ['nombre_columna' => 'nombre_completo', 'tipo_dato' => 'varchar(255)'],
            ['nombre_columna' => 'correo', 'tipo_dato' => 'varchar(255)', 'unica' => 1],
            ['nombre_columna' => 'telefono', 'tipo_dato' => 'varchar(20)', 'nullable' => 1],
        ];

        foreach ($columnas as $col) {
            DB::table('columnas_tablas')->insert([
                'id_tabla' => $tablaId,
                'nombre_columna' => $col['nombre_columna'],
                'tipo_dato' => $col['tipo_dato'],
                'qty_caracteres' => null,
                'es_llave_primaria' => $col['es_llave_primaria'] ?? 0,
                'es_foranea' => 0,
                'on_table' => null,
                'on_column' => null,
                'nullable' => $col['nullable'] ?? 0,
                'activo' => true,
                'unica' => $col['unica'] ?? 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
