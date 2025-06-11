<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
            DB::table('users')->insert([
                'id' => 'ed2e616e-b4d0-4a9d-bd9f-39cad65aadc0',
                'name' => 'Eugenio',
                'lastname' => 'Ortiz',
                'avatar' => null,
                'telephone' => '4611150766',
                'email' => 'eoc900@gmail.com',
                'codigo_maestro' => null,
                'codigo_activacion' => null,
                'creado_por' => null,
                'actualizado_por' => null,
                'estado' => 'Activo',
                'user_type' => 'Admin',
                'ultimo_inicio' => Carbon::now(),
                'fecha_activacion' => Carbon::now(),
                'fecha_ultimo_invite' => null,
                'envio_fecha_reset_codigo' => null,
                'fecha_envio_verificacion' => null,
                'codigo_reset' => null,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('123Eoc900'), // Cambia esto por una contraseña segura
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Puedes agregar más usuarios aquí si lo necesitas
        }
}
