<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MateriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

         DB::table['permissions']->insert([
        ['id'=>'011e955e-5666-4f21-a0b0-be60977d8b57','clave'=>'CA529','cuatrimestre'=>5,'credito'=>6,'materia'=>'Biología','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:06:54','updated_at'=>'2025-01-23 01:06:54'],
        ['id'=>'02a1e328-4c94-4e56-aebc-7f0271593bb8','clave'=>'TC317','cuatrimestre'=>3,'credito'=>6,'materia'=>'Textos Literarios II','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:55:59','updated_at'=>'2025-01-23 00:55:59'],
        ['id'=>'02e0cc9a-9c5e-4ff9-8a29-ab4b907166f1','clave'=>'H424','cuatrimestre'=>4,'credito'=>6,'materia'=>'Principios de Física','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:01:05','updated_at'=>'2025-01-23 01:01:05'],
        ['id'=>'0634afda-b60a-485d-ad0f-b0200de2015c','clave'=>'TC633','cuatrimestre'=>6,'credito'=>6,'materia'=>'Historia de México II','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:10:31','updated_at'=>'2025-01-23 01:10:31'],
        ['id'=>'07c5b19e-c2f6-4aa3-b056-3d04249fd4b7','clave'=>'FM635','cuatrimestre'=>6,'credito'=>6,'materia'=>'Biología','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:13:59','updated_at'=>'2025-01-23 01:13:59'],
        ['id'=>'0c5d242c-bc0d-4af6-b8c6-fbc9bb5c20ce','clave'=>'CA423','cuatrimestre'=>4,'credito'=>6,'materia'=>'Principios de Química','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:01:50','updated_at'=>'2025-01-23 01:01:50'],
        ['id'=>'1142bf9f-9d3f-4a2d-bfd4-247377e13cd3','clave'=>'TC211','cuatrimestre'=>2,'credito'=>4,'materia'=>'Apreciación Estética [Pintura]','seriada'=>0,'activo'=>1,'created_at'=>'2025-01-23 00:52:54','updated_at'=>'2025-01-23 00:52:54'],
        ['id'=>'16d5859e-16c4-416c-b7b2-ad347b57e456','clave'=>'FM423','cuatrimestre'=>4,'credito'=>6,'materia'=>'Química','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:03:32','updated_at'=>'2025-01-23 01:03:32'],
        ['id'=>'17409a75-7c76-4431-87fc-a4ba473ef601','clave'=>'TC419','cuatrimestre'=>4,'credito'=>6,'materia'=>'Inglés IV','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-22 09:50:13','updated_at'=>'2025-01-23 01:02:23'],
        ['id'=>'22645b36-45aa-4838-a077-34e8a8c45273','clave'=>'FM529','cuatrimestre'=>5,'credito'=>6,'materia'=>'Física II','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:07:47','updated_at'=>'2025-01-23 01:07:47'],
        ['id'=>'26988b11-2e06-4cec-af54-d4a8393ffc29','clave'=>'TC318','cuatrimestre'=>3,'credito'=>4,'materia'=>'Textos Filosóficos I','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:57:13','updated_at'=>'2025-01-23 00:57:13'],
        ['id'=>'2822c428-41c0-419d-8b12-ded22e70f40e','clave'=>'TC527','cuatrimestre'=>5,'credito'=>6,'materia'=>'Bioética','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:05:16','updated_at'=>'2025-01-23 01:05:16'],
        ['id'=>'28834ca8-5187-4f72-824c-88f547cb85aa','clave'=>'TC208','cuatrimestre'=>2,'credito'=>6,'materia'=>'Matemáticas II','seriada'=>1,1,'created_at'=>'2025-01-23 00:51:25','updated_at'=>'2025-01-23 00:51:25'],
        ['id'=>'2b023a7b-d993-4547-b804-b4aabba25422','clave'=>'H530','cuatrimestre'=>5,'credito'=>6,'materia'=>'Principios de Química',1,'activo'=>1,'created_at'=>'2025-01-23 01:06:31','updated_at'=>'2025-01-23 01:06:31'],
        ['id'=>'2bc5c843-ef77-4e35-860c-b5c0f8dd212c','clave'=>'TC101','cuatrimestre'=>1,'credito'=>6,'materia'=>'Inglés I','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:48:35','updated_at'=>'2025-01-23 00:48:35'],
        ['id'=>'33c99154-cee7-432a-8afe-e41952305dbd','clave'=>'H529','cuatrimestre'=>5,'credito'=>6,'materia'=>'Biología','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:06:07','updated_at'=>'2025-01-23 01:06:07'],
        ['id'=>'468d5d48-c545-4139-ab69-3f7dd7e3c115','clave'=>'TC420','cuatrimestre'=>4,'credito'=>6,'materia'=>'Matemáticas IV','seriada'=>1,1,'created_at'=>'2025-01-23 00:58:55','updated_at'=>'2025-01-23 00:58:55'],
        ['id'=>'4719c345-be87-42de-87d5-0d216acb40d8','clave'=>'TC212','cuatrimestre'=>2,'credito'=>4,'materia'=>'Textos Literarios I','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:53:48','updated_at'=>'2025-01-23 00:53:48'],
        ['id'=>'4abdf9ad-b196-4b67-a996-e0d40e2cec61','clave'=>'H635','cuatrimestre'=>6,'credito'=>4,'materia'=>'Textos Políticos y Sociales','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:11:41','updated_at'=>'2025-01-23 01:11:41'],
        ['id'=>'4e400f6e-13c6-4c8d-ae4a-c0fe06f18ff0','clave'=>'TC106','cuatrimestre'=>1,'credito'=>4,'materia'=>'Metodología del aprendizaje','seriada'=>0,'activo'=>1,'created_at'=>'2025-01-23 00:50:46','updated_at'=>'2025-01-23 00:50:46'],
        ['id'=>'5bbd5a97-fdb1-4b0d-823a-09d828371941','clave'=>'TC525','cuatrimestre'=>5,'credito'=>6,'materia'=>'Inglés V','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:04:24','updated_at'=>'2025-01-23 01:04:24'],
        ['id'=>'6649b5be-d478-4b0f-8fa9-4960850f8147','clave'=>'TC422','cuatrimestre'=>4,'credito'=>6,'materia'=>'Introducción a las Ciencias Sociales','seriada'=>1,'activo'=>0,'created_at'=>'2025-01-23 01:00:12','updated_at'=>'2025-01-23 01:00:12'],
        ['id'=>'68ad5c73-a296-4b0f-ae37-5ba90b536af6','clave'=>'TC104','cuatrimestre'=>1,'credito'=>4,'materia'=>'Taller de Redacción I','seriada'=>0,'activo'=>1,'created_at'=>'2025-01-23 00:49:53','updated_at'=>'2025-01-23 00:49:53'],
        ['id'=>'6f50d16f-0c28-4b2e-87ab-8f2c2a655047','clave'=>'TC632','cuatrimestre'=>6,'credito'=>6,'materia'=>'Textos Científicos','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:09:54','updated_at'=>'2025-01-23 01:09:54'],
        ['id'=>'6f99992e-fb56-4228-bc63-8763d48cfb3e','clave'=>'TC102','cuatrimestre'=>1,'credito'=>6,'materia'=>'Matemáticas I','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:48:51','updated_at'=>'2025-01-23 00:48:51'],
        ['id'=>'784f1c96-c13b-4c7c-ab0a-a6f5ed79260d','clave'=>'TC631','cuatrimestre'=>6,'credito'=>6,'materia'=>'Inglés VI','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:09:31','updated_at'=>'2025-01-23 01:09:31'],
        ['id'=>'797ccf24-972f-4977-ad8e-18c1f462a5d2','clave'=>'TC209','cuatrimestre'=>2,'credito'=>4,'materia'=>'Historia Mundial Contemporánea','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:51:57','updated_at'=>'2025-01-23 00:51:57'],
        ['id'=>'85e9a64c-be48-4729-9022-699cac6e3160','clave'=>'H636','cuatrimestre'=>6,'credito'=>4,'materia'=>'Actividades Estéticas [Música]','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:12:12','updated_at'=>'2025-01-23 01:12:12'],
        ['id'=>'8e3e0f1f-7f89-4f0a-8f38-8e7581ac6088','clave'=>'FM424','cuatrimestre'=>4,'credito'=>6,'materia'=>'Física I','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:03:55','updated_at'=>'2025-01-23 01:03:55'],
        ['id'=>'8ec34260-50e6-4833-b3bf-20b31cb884fa','clave'=>'TC313','cuatrimestre'=>3,'credito'=>6,'materia'=>'Inglés III','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:54:06','updated_at'=>'2025-01-23 00:58:09'],
        ['id'=>'923bb3fe-bcdb-4212-a2c8-97ae00b8cf4f','clave'=>'TC421','cuatrimestre'=>4,'credito'=>4,'materia'=>'Textos Filosóficos II','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:59:25','updated_at'=>'2025-01-23 00:59:25'],
        ['id'=>'95ca7f57-af38-4a8f-919e-9b4be0d05059','clave'=>'TC316','cuatrimestre'=>3,'credito'=>4,'materia'=>'Taller de Redacción III','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:55:23','updated_at'=>'2025-01-23 00:55:23'],
        ['id'=>'97589065-cc95-4d95-b5d2-edd0731d02fb','clave'=>'TC207','cuatrimestre'=>2,'credito'=>6,'materia'=>'Inglés II','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:51:07','updated_at'=>'2025-01-23 00:51:07'],
        ['id'=>'97d87ea3-15de-48c7-b53d-93488b8cad41','clave'=>'CA424','cuatrimestre'=>4,'credito'=>6,'materia'=>'Principios de Física','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:03:04','updated_at'=>'2025-01-23 01:03:04'],
        ['id'=>'9f0fe366-423c-431a-a6e9-db80651b0407','clave'=>'FM636','cuatrimestre'=>6,'credito'=>6,'materia'=>'Matemáticas VI','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:14:35','updated_at'=>'2025-01-23 01:14:35'],
        ['id'=>'a2328e81-f98b-4f9d-ab97-9f296a41e764','clave'=>'TC634','cuatrimestre'=>6,'credito'=>6,'materia'=>'Problemas Socioeconómicos de México','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:11:05','updated_at'=>'2025-01-23 01:11:05'],
        ['id'=>'a4383991-0128-4d8d-b5cd-26817d22f035','clave'=>'TC210','cuatrimestre'=>2,'credito'=>4,'materia'=>'Taller de Redacción II','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:52:21','updated_at'=>'2025-01-23 00:52:21'],
        ['id'=>'a65e436a-bfc1-4f7c-9c0e-5acc412ad343','clave'=>'TC528','cuatrimestre'=>5,'credito'=>6,'materia'=>'Historia de México I','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:05:46','updated_at'=>'2025-01-23 01:05:46'],
        ['id'=>'bfe89c3c-0e2a-40aa-86e1-75572fc244ac','clave'=>'H423','cuatrimestre'=>4,'credito'=>6,'materia'=>'Textos Literarios III','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:00:40','updated_at'=>'2025-01-23 01:00:40'],
        ['id'=>'c30219f3-4b4e-43e9-b0dc-e4236f4a360d','clave'=>'TC526','cuatrimestre'=>5,'credito'=>6,'materia'=>'Textos Políticos Y Sociales I','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:04:53','updated_at'=>'2025-01-23 01:04:53'],
        ['id'=>'c7954b09-a27e-4c14-88ec-e8dd5b554fca','clave'=>'FM530','cuatrimestre'=>5,'credito'=>6,'materia'=>'Matemáticas V','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:08:13','updated_at'=>'2025-01-23 01:08:13'],
        ['id'=>'d7a37a2d-410b-4e40-93e0-4daf325fed95','clave'=>'TC103','cuatrimestre'=>1,'credito'=>4,'materia'=>'Historia Moderna de Occidente','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:49:26','updated_at'=>'2025-01-23 00:49:26'],
        ['id'=>'d8513ff0-a053-44d4-8a0c-6275293433db','clave'=>'TC105','cuatrimestre'=>1,'credito'=>6,'materia'=>'Metodología de la Lectura','seriada'=>0,'activo'=>1,'created_at'=>'2025-01-23 00:50:20','updated_at'=>'2025-01-23 00:50:20'],
        ['id'=>'d8ee7a78-f5e7-4b8e-8261-e58172917017','clave'=>'CA636','cuatrimestre'=>6,'credito'=>6,'materia'=>'Matemáticas VI','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:13:35','updated_at'=>'2025-01-23 01:13:35'],
        ['id'=>'e744b82a-473f-40d8-8c58-096fa232f381','clave'=>'TC315','cuatrimestre'=>3,'credito'=>4,'materia'=>'Lógica','seriada'=>0,'activo'=>1,'created_at'=>'2025-01-23 00:54:52','updated_at'=>'2025-01-23 00:54:52'],
        ['id'=>'f59b4c99-b292-4f01-b7a9-4ad182c699e2','clave'=>'TC314','cuatrimestre'=>3,'credito'=>6,'materia'=>'Matemáticas III','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 00:54:26','updated_at'=>'2025-01-23 00:54:26'],
        ['id'=>'f7307361-4241-49e2-aaf2-3a316da280bb','clave'=>'CA530','cuatrimestre'=>5,'credito'=>6,'materia'=>'Matemáticas V','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:07:17','updated_at'=>'2025-01-23 01:07:17'],
        ['id'=>'f7417720-d42b-4490-81b9-40638c4776c0','clave'=>'CA635','cuatrimestre'=>6,'credito'=>6,'materia'=>'Textos Políticos y Sociales II','seriada'=>1,'activo'=>1,'created_at'=>'2025-01-23 01:13:03','updated_at'=>'2025-01-23 01:13:03']
         ]);
    }
}
