<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'Generar tablas',
            'Cargar tablas',
            'Crear queries',
            'Crear formularios',
            'Crear liga',
            'Crear dashboards',
            'Crear informe',
            'Ver queries',
            'Ver archivos',
            'Ver tablas',
            'Ver informes',
            'Ver formularios',
            'Ver ligas',
            'Borrar formularios',
            'Eliminar tablas modulos',
            'Eliminar informes',
            'Eliminar archivos'          
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        // Asignar permisos básicos por rol
        $admin = Role::firstWhere('name', 'administrador tecnológico');
        $owner = Role::firstWhere('name', 'owner');
        $colab = Role::firstWhere('name', 'colaborador');

        $admin->syncPermissions(Permission::all());

        $owner->syncPermissions([
            'Generar tablas',
            'Cargar tablas',
            'Crear formularios',
            'Crear liga',
            'Ver informes',
            'Ver formularios',
            'Ver ligas',
            'Ver archivos',
            'Ver tablas',
            'Borrar formularios'
        ]);

        $colab->syncPermissions([
            'Ver formularios'
        ]);
    }
}
