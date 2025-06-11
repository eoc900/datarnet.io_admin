<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
        ["id"=>1, "name"=>"Developer", "guard_name"=>"web", "created_at"=>'2024-08-09 06:19:51', "updated_at"=>'2024-08-09 06:19:51'],
        ["id"=>2, "name"=>"Admin", "guard_name"=>"web", "created_at"=>'2024-08-09 06:19:51', "updated_at"=>'2024-08-09 06:19:51'],
        ["id"=>3, "name"=>"Guest", "guard_name"=>"web", "created_at"=>'2024-08-09 06:19:51', "updated_at"=>'2024-08-09 06:19:51'],
        ["id"=>4, "name"=>"Tesorería", "guard_name"=>"web", "created_at"=>'2024-08-09 06:19:51', "updated_at"=>'2024-08-09 06:19:51'],
        ["id"=>5, "name"=>"Base de datos", "guard_name"=>"web", "created_at"=>'2024-08-09 06:19:51', "updated_at"=>'2024-08-09 06:19:51'],
        ["id"=>6, "name"=>"Celaya", "guard_name"=>"web", "created_at"=>'2024-08-09 06:19:51', "updated_at"=>'2024-08-09 06:19:51'],
        ["id"=>7, "name"=>"Irapuato", "guard_name"=>"web", "created_at"=>'2024-08-09 06:19:51', "updated_at"=>'2024-08-09 06:19:51'],
        ["id"=>8, "name"=>"Acámbaro", "guard_name"=>"web", "created_at"=>'2024-08-09 06:19:51', "updated_at"=>'2024-08-09 06:19:51'],
        ["id"=>9, "name"=>"Control de títulos", "guard_name"=>"web", "created_at"=>'2024-08-09 06:19:51', "updated_at"=>'2024-08-09 06:19:51']]);
    }
}
