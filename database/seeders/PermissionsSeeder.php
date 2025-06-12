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
            'ver reportes',
            'crear reportes',
            'editar reportes',
            'eliminar reportes',
            'gestionar usuarios',
            'configurar sistema',
            'cargar tabla documento excel',
            'crear formulario',
            'ver formulario'
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
            'ver reportes',
            'crear reportes',
            'editar reportes',
        ]);

        $colab->syncPermissions([
            'ver reportes',
        ]);
    }
}
