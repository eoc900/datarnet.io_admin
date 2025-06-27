<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposDatosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // ----> Creado por id default: ebba3771-798d-4364-b729-7d4d800a4fcb
        DB::table('tipos_datos')->insert([
            ['tipo_dato' => 'Entero',
            'created_at' => now(),
            'updated_at' => now()],
             ['tipo_dato' => 'Decimal',
            'created_at' => now(),
            'updated_at' => now()],
             ['tipo_dato' => 'Booleano',
            'created_at' => now(),
            'updated_at' => now()],
            ['tipo_dato' => 'Cadena',
            'created_at' => now(),
            'updated_at' => now()],
            ['tipo_dato' => 'Fecha/Tiempo',
            'created_at' => now(),
            'updated_at' => now()],
             ['tipo_dato' => 'Fecha',
            'created_at' => now(),
            'updated_at' => now()],
            ['tipo_dato' => 'Tiempo',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['tipo_dato' => 'BigEntero/Llaveforanea',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
