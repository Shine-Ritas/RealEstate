<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = ['create', 'update', 'delete', 'view'];
        $modules = ['users', 'roles', 'permissions', 'property_types', 'projects', 'properties', 'bookings', 'reports', 'settings'];

        $roles = ['admin', 'agent', 'user', 'data-entry'];

        foreach ($roles as $role) {
            $role = Role::create([
                'name' => $role,
            ]);
        }

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permission = Permission::create([
                    'name' => $action.'-'.$module,
                ]);
            }
        }

        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo(Permission::all());
    }
}
