<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin','guard_name' => 'api']);
        $doctor = Role::create(['name' => 'doctor','guard_name' => 'api']);
        $researcher = Role::create(['name' => 'researcher','guard_name' => 'api']);

    Permission::create(['name' => 'create_patient','guard_name' => 'api']);
    Permission::create(['name' => 'update_patient','guard_name' => 'api']);
    Permission::create(['name' => 'delete_patient','guard_name' => 'api']);
    Permission::create(['name' => 'view_patient','guard_name' => 'api']);

    $admin->givePermissionTo(Permission::all());
    $doctor->givePermissionTo(['create_patient','update_patient', 'view_patient']);
    $researcher->givePermissionTo(['view_patient']);
    }
}
