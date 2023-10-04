<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $categories = Role::create(['name' => 'categories', 'guard_name' => 'admin', 'deletable' => 0]);
        $categories->givePermissionTo(Permission::where('section', 'categories')->get());

        $posts      = Role::create(['name' => 'posts', 'guard_name' => 'admin', 'deletable' => 0]);
        $posts->givePermissionTo(Permission::where('section', 'posts')->get());

        $users      = Role::create(['name' => 'users', 'guard_name' => 'admin', 'deletable' => 0]);
        $users->givePermissionTo(Permission::where('section', 'users')->get());

        $comments   = Role::create(['name' => 'comments', 'guard_name' => 'admin', 'deletable' => 0]);
        $comments->givePermissionTo(Permission::where('section', 'comments')->get());

        $contacts   = Role::create(['name' => 'contacts', 'guard_name' => 'admin', 'deletable' => 0]);
        $contacts->givePermissionTo(Permission::where('section', 'contacts')->get());

        $pages      = Role::create(['name' => 'pages', 'guard_name' => 'admin', 'deletable' => 0]);
        $pages->givePermissionTo(Permission::where('section', 'pages')->get());

        $settings   = Role::create(['name' => 'settings', 'guard_name' => 'admin', 'deletable' => 0]);
        $settings->givePermissionTo(Permission::where('section', 'settings')->get());

        $admins     = Role::create(['name' => 'admins', 'guard_name' => 'admin', 'deletable' => 0]);
        $admins->givePermissionTo(Permission::where('section', 'admins')->get());

        $permissions = Role::create(['name' => 'permissions', 'guard_name' => 'admin', 'deletable' => 0]);
        $permissions->givePermissionTo(Permission::where('section', 'permissions')->get());

        $roles      = Role::create(['name' => 'roles', 'guard_name' => 'admin', 'deletable' => 0]);
        $roles->givePermissionTo(Permission::where('section', 'roles')->get());

        $superAdmin      = Role::create(['name' => 'super admin', 'guard_name' => 'admin', 'deletable' => 0]);
        $superAdmin->givePermissionTo(Permission::get());
    
    }
}
