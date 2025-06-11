<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
          ['id'=>1,'name'=>'Agregar escuelas','guard_name'=>'web','created_at'=>'2024-08-13 00:26:45','updated_at'=>'2024-09-23 03:21:28'],
          ["id"=>2,"name"=>'Editar escuelas','guard_name'=>'web','created_at'=>'2024-08-13 00:58:50','updated_at'=>'2024-11-12 23:14:30'],
          ["id"=>3,"name"=>'Ver escuelas','guard_name'=>'web','created_at'=>'2024-08-13 00:59:04','updated_at'=>'2024-11-12 23:14:24'],
          ["id"=>4,"name"=>'Agregar usuarios','guard_name'=>'web','created_at'=>'2024-08-13 01:00:43','updated_at'=>'2024-11-12 23:14:40'],
          ["id"=>5,"name"=>'Editar usuarios','guard_name'=>'web','created_at'=>'2024-08-13 01:00:50','updated_at'=>'2024-11-12 23:14:48'],
          ["id"=>6,"name"=>'Eliminar usuario','guard_name'=>'web','created_at'=>'2024-08-13 01:01:00','update_at'=>'2024-08-13 01:01:00'],
          ["id"=>7,"name"=>'Ver usuarios','guard_name'=>'web','created_at'=>'2024-08-13 01:01:05','updated_at'=>'2024-11-12 23:14:53'],
          ["id"=>8,"name"=>'Agregar sistema académico','guard_name'=>'web','created_at'=>'2024-08-13 01:01:58','updated_at'=>'2024-08-13 01:01:58'],
          ["id"=>9,"name"=>'Editar sistema académico','guard_name'=>'web','created_at'=>'2024-08-13 01:02:07','updated_at'=>'2024-08-13 01:02:07'],
          ["id"=>10,"name"=>'Eliminar sistema académico','guard_name'=>'web','created_at'=>'2024-08-13 01:02:23','updated_at'=>'2024-08-13 01:02:23'],
          ["id"=>11,"name"=>'Ver sistema académico','guard_name'=>'web','created_at'=>'2024-08-13 01:03:01','updated_at'=>'2024-08-13 01:03:01'],
          ["id"=>12,"name"=>'Agregar concepto de cobro','guard_name'=>'web','created_at'=>'2024-08-13 01:03:17','updated_at'=>'2024-08-13 01:03:17'],
          ["id"=>13,"name"=>'Editar concepto de cobro','guard_name'=>'web','created_at'=>'2024-08-13 01:03:22','updated_at'=>'2024-08-13 01:03:22'],
          ["id"=>14,"name"=>'Eliminar concepto de cobro','guard_name'=>'web','created_at'=>'2024-08-13 01:03:28','updated_at'=>'2024-08-13 01:03:28'],
          ["id"=>15,"name"=>'Ver concepto de cobro','guard_name'=>'web','created_at'=>'2024-08-13 01:03:34','updated_at'=>'2024-08-13 01:03:34'],
          ["id"=>16,"name"=>'Agregar costo a concepto','guard_name'=>'web','created_at'=>'2024-08-13 01:04:28','updated_at'=>'2024-08-13 01:04:28'],
          ["id"=>17,"name"=>'Editar costo a concepto','guard_name'=>'web','created_at'=>'2024-08-13 01:04:36','updated_at'=>'2024-08-13 01:04:36'],
          ["id"=>18,"name"=>'Eliminar costo a concepto','guard_name'=>'web','created_at'=>'2024-08-13 01:04:42','updated_at'=>'2024-08-13 01:04:42'],
          ["id"=>19,"name"=>'Ver costo a concepto','guard_name'=>'web','created_at'=>'2024-08-13 01:04:50','updated_at'=>'2024-08-13 01:04:50'],
          ["id"=>20,"name"=>'Agregar alumno','guard_name'=>'web','created_at'=>'2024-08-13 01:05:50','updated_at'=>'2024-08-13 01:05:50'],
          ["id"=>21,"name"=>'Editar alumno','guard_name'=>'web','created_at'=>'2024-08-13 01:05:54','updated_at'=>'2024-08-13 01:05:54'],
          ["id"=>22,"name"=>'Eliminar alumno','guard_name'=>'web','created_at'=>'2024-08-13 01:06:16','updated_at'=>'2024-08-13 01:06:16'],
          ["id"=>23,"name"=>'Ver alumno','guard_name'=>'web','created_at'=>'2024-08-13 01:06:26','updated_at'=>'2024-08-13 01:06:26'],
          ["id"=>24,"name"=>'Generar cuenta','guard_name'=>'web','created_at'=>'2024-08-13 01:09:47','updated_at'=>'2024-08-13 01:09:47'],
          ["id"=>25,"name"=>'Editar cuenta','guard_name'=>'web','created_at'=>'2024-08-13 01:09:52','updated_at'=>'2024-08-13 01:09:52'],
          ["id"=>26,"name"=>'Eliminar cuenta','guard_name'=>'web','created_at'=>'2024-08-13 01:09:57','updated_at'=>'2024-08-13 01:09:57'],
          ["id"=>27,"name"=>'Ver cuenta','guard_name'=>'web','created_at'=>'2024-08-13 01:10:02','updated_at'=>'2024-08-13 01:10:02'],
          ["id"=>28,"name"=>'Agregar un descuento','guard_name'=>'web','created_at'=>'2024-09-23 06:24:37','updated_at'=>'2024-09-23 06:24:37'],
          ["id"=>29,"name"=>'Editar un descuento','guard_name'=>'web','created_at'=>'2024-09-23 06:25:08','updated_at'=>'2024-09-23 06:25:08'],
          ["id"=>30,"name"=>'Eliminar un Descuento','guard_name'=>'web','created_at'=>'2024-09-23 06:25:20','updated_at'=>'2024-09-23 06:25:20'],
          ["id"=>31,"name"=>'Ver Descuento','guard_name'=>'web','created_at'=>'2024-09-23 06:25:45','updated_at'=>'2024-09-23 06:25:45'],
          ["id"=>32,"name"=>'Agregar materias','guard_name'=>'web','created_at'=>'2024-11-12 22:50:26','updated_at'=>'2024-11-12 22:50:26'],
          ["id"=>33,"name"=>'Editar materia','guard_name'=>'web','created_at'=>'2024-11-12 23:05:13','updated_at'=>'2025-01-22 06:46:42'],
          ["id"=>34,"name"=>'Eliminar materia','guard_name'=>'web','created_at'=>'2024-11-12 23:05:25','updated_at'=>'2025-01-22 06:46:51'],
          ["id"=>35,"name"=>'Agregar contactos de alumnos','guard_name'=>'web','created_at'=>'2024-11-12 23:09:03','updated_at'=>'2024-11-12 23:09:03'],
          ["id"=>36,"name"=>'Agregar promociones','guard_name'=>'web','created_at'=>'2024-11-12 23:09:46','updated_at'=>'2024-11-12 23:09:46'],
          ["id"=>37,"name"=>'Editar promociones','guard_name'=>'web','created_at'=>'2024-11-12 23:09:52','updated_at'=>'2024-11-12 23:09:52'],
          ["id"=>38,"name"=>'Eliminar promociones','guard_name'=>'web','created_at'=>'2024-11-12 23:09:58','updated_at'=>'2024-11-12 23:09:58'],
          ["id"=>39,"name"=>'Ver promociones','guard_name'=>'web','created_at'=>'2024-11-12 23:10:03','updated_at'=>'2024-11-12 23:10:03'],
          ["id"=>40,"name"=>'Ver materias','guard_name'=>'web','created_at'=>'2024-11-12 23:15:08','updated_at'=>'2024-11-12 23:15:08'],
          ["id"=>41,"name"=>'Eliminar escuelas','guard_name'=>'web','created_at'=>'2024-11-12 23:15:35','updated_at'=>'2024-11-12 23:15:35'],
          ["id"=>42,"name"=>'Ver alumnos','guard_name'=>'web','2024-11-24 02:47:57','updated_at'=>'2024-11-24 02:47:57'],
          ["id"=>43,"name"=>'Ver inscripciones','guard_name'=>'web','created_at'=>'2024-11-24 03:27:33','updated_at'=>'2024-11-24 03:27:33'],
          ["id"=>44,"name"=>'Agregar inscripción','guard_name'=>'web','created_at'=>'2024-11-24 03:29:37','updated_at'=>'2024-11-24 03:29:37'],
          ["id"=>45,"name"=>'Ver materias cargadas','guard_name'=>'web','created_at'=>'2024-11-27 04:47:26','updated_at'=>'2024-11-27 04:47:26'],
          ["id"=>46,"name"=>'Ver maestros','guard_name'=>'web','created_at'=>'2024-12-22 01:07:50','updated_at'=>'2024-12-22 01:08:13'],
          ["id"=>47,"name"=>'Ver maestro','guard_name'=>'web','created_at'=>'2024-12-22 01:08:24','updated_at'=>'2024-12-22 01:08:24'],
          ["id"=>48,"name"=>'Editar maestro','guard_name'=>'web','created_at'=>'2024-12-22 01:08:29','updated_at'=>'2024-12-22 01:08:29'],
          ["id"=>49,"name"=>'Eliminar maestro','guard_name'=>'web','created_at'=>'2024-12-22 01:08:37','updated_at'=>'2024-12-22 01:08:37'],
          ["id"=>50,"name"=>'Agregar maestro','guard_name'=>'web','created_at'=>'2024-12-22 01:09:47','updated_at'=>'2024-12-22 01:09:47'],
          ["id"=>51,"name"=>'Currícula maestro','guard_name'=>'web','created_at'=>'2025-01-21 01:11:18','updated_at'=>'2025-01-21 01:11:18'],
          ["id"=>52,"name"=>'Modificar materias maestro','guard_name'=>'web','created_at'=>'2025-01-21 01:11:43','updated_at'=>'2025-01-21 01:11:43'],
          ["id"=>53,"name"=>'Definir disponibilidad maestro','guard_name'=>'web','created_at'=>'2025-01-21 01:11:54','updated_at'=>'2025-01-21 01:11:54'],
          ["id"=>54,"name"=>'Buscar disponibilidad maestro','guard_name'=>'web','created_at'=>'2025-01-21 01:12:04','updated_at'=>'2025-01-21 01:12:04'],
          ["id"=>55,"name"=>'Manejar tipos de correos de maestros','guard_name'=>'web','created_at'=>'2025-01-21 01:12:23','updated_at'=>'2025-01-21 01:13:34'],
          ["id"=>56,"name"=>'Generar currícula','guard_name'=>'web','created_at'=>'2025-01-22 23:00:59','updated_at'=>'2025-01-22 23:00:59'],
          ["id"=>57,"name"=>'Generar tablas','guard_name'=>'web','created_at'=>'2025-01-22 23:00:59','updated_at'=>'2025-01-22 23:00:59'],
          ["id"=>58,"name"=>'Crear queries','guard_name'=>'web','created_at'=>'2025-01-22 23:00:59','updated_at'=>'2025-01-22 23:00:59'],
          ["id"=>59,"name"=>'Ver queries','guard_name'=>'web','created_at'=>'2025-01-22 23:00:59','updated_at'=>'2025-01-22 23:00:59'],
          ["id"=>60,"name"=>'Generar dashboards','guard_name'=>'web','created_at'=>'2025-01-22 23:00:59','updated_at'=>'2025-01-22 23:00:59'],
          ["id"=>61,"name"=>'Ver dashboards','guard_name'=>'web','created_at'=>'2025-01-22 23:00:59','updated_at'=>'2025-01-22 23:00:59'],
          ["id"=>62,"name"=>'Ver archivos','guard_name'=>'web','created_at'=>'2025-01-22 23:00:59','updated_at'=>'2025-01-22 23:00:59'],
          ["id"=>63,"name"=>'Ver tablas','guard_name'=>'web','created_at'=>'2025-01-22 23:00:59','updated_at'=>'2025-01-22 23:00:59'],
          ["id"=>64,"name"=>'Crear formularios','guard_name'=>'web','created_at'=>'2025-01-22 23:00:59','updated_at'=>'2025-01-22 23:00:59'],
          ["id"=>65,"name"=>'Ver formularios','guard_name'=>'web','created_at'=>'2025-01-22 23:00:59','updated_at'=>'2025-01-22 23:00:59'],
          ["id"=>66,"name"=>'Ver títulos','guard_name'=>'web','created_at'=>'2025-01-22 23:00:59','updated_at'=>'2025-01-22 23:00:59'],
          ["id"=>67,"name"=>'Crear dashboards','guard_name'=>'web','created_at'=>'2025-01-22 23:00:59','updated_at'=>'2025-01-22 23:00:59']

        ]);
    }
}
