<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('model_has_roles')->insert([
            ["role_id"=>2,"model_type"=>"App\Models\User","model_id"=>"ed2e616e-b4d0-4a9d-bd9f-39cad65aadc0"]
         ]);
    }
}
