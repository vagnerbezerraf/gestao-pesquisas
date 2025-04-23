<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::firstOrCreate(['name' => 'manage surveys']);
        Permission::firstOrCreate(['name' => 'respond surveys']);

        // create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'Administrador']);
        $admin->syncPermissions(Permission::all());

        $gestor = Role::firstOrCreate(['name' => 'Gestor']);
        $gestor->syncPermissions('manage surveys');

        Role::firstOrCreate(['name' => 'Participante']);
    }
}
