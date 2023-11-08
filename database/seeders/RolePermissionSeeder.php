<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions  = [
            "role_add",
            "role_edit",
            "role_view",
            "role_delete",
            "role_export",
            "role_import",

            "user_add",
            "user_edit",
            "user_view",
            "user_delete",
            "user_export",
            "user_import",

            "employee_add",
            "employee_edit",
            "employee_view",
            "employee_delete",
            "employee_export",
            "employee_import",

            // "_add",
            // "_edit",
            // "_view",
            // "_delete",
            // "_export",
            // "_import",
        ];

        //create permission
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        $roles = ["admin", "hr", "employee"];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
            ]);
        }
    }
}
