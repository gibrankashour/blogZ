<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Categories
        Permission::create(['name' => 'show categories', 'guard_name' => 'admin', 'section' => 'categories']);
        Permission::create(['name' => 'store category', 'guard_name' => 'admin', 'section' => 'categories']);
        Permission::create(['name' => 'edit category', 'guard_name' => 'admin', 'section' => 'categories']);
        Permission::create(['name' => 'delete category', 'guard_name' => 'admin', 'section' => 'categories']);
        
        // Posts
        Permission::create(['name' => 'show posts', 'guard_name' => 'admin', 'section' => 'posts']);
        Permission::create(['name' => 'store post', 'guard_name' => 'admin', 'section' => 'posts']);
        Permission::create(['name' => 'edit post', 'guard_name' => 'admin', 'section' => 'posts']);
        Permission::create(['name' => 'delete post', 'guard_name' => 'admin', 'section' => 'posts']);
        
        // Users
        Permission::create(['name' => 'show users', 'guard_name' => 'admin', 'section' => 'users']);
        Permission::create(['name' => 'store user', 'guard_name' => 'admin', 'section' => 'users']);
        Permission::create(['name' => 'edit user', 'guard_name' => 'admin', 'section' => 'users']);
        Permission::create(['name' => 'delete user', 'guard_name' => 'admin', 'section' => 'users']);
        
        // Comments
        Permission::create(['name' => 'show comments', 'guard_name' => 'admin', 'section' => 'comments']);
        Permission::create(['name' => 'store comment', 'guard_name' => 'admin', 'section' => 'comments']);
        Permission::create(['name' => 'activate comment', 'guard_name' => 'admin', 'section' => 'comments']);
        Permission::create(['name' => 'delete comment', 'guard_name' => 'admin', 'section' => 'comments']);
        
        // Contact
        Permission::create(['name' => 'show contacts', 'guard_name' => 'admin', 'section' => 'contacts']);
        Permission::create(['name' => 'replay contact', 'guard_name' => 'admin', 'section' => 'contacts']);
        Permission::create(['name' => 'delete contact', 'guard_name' => 'admin', 'section' => 'contacts']);
        
        // Pages
        Permission::create(['name' => 'show pages', 'guard_name' => 'admin', 'section' => 'pages']);
        Permission::create(['name' => 'store page', 'guard_name' => 'admin', 'section' => 'pages']);
        Permission::create(['name' => 'edit page', 'guard_name' => 'admin', 'section' => 'pages']);
        Permission::create(['name' => 'delete page', 'guard_name' => 'admin', 'section' => 'pages']);    
        
        // Settings
        Permission::create(['name' => 'show settings', 'guard_name' => 'admin', 'section' => 'settings']);
        Permission::create(['name' => 'store setting', 'guard_name' => 'admin', 'section' => 'settings']);
        Permission::create(['name' => 'edit setting', 'guard_name' => 'admin', 'section' => 'settings']);
        Permission::create(['name' => 'delete setting', 'guard_name' => 'admin', 'section' => 'settings']);    
    
        
        // Admins
        Permission::create(['name' => 'show admins', 'guard_name' => 'admin', 'section' => 'admins']);
        Permission::create(['name' => 'store admin', 'guard_name' => 'admin', 'section' => 'admins']);
        Permission::create(['name' => 'edit admin', 'guard_name' => 'admin', 'section' => 'admins']);
        Permission::create(['name' => 'delete admin', 'guard_name' => 'admin', 'section' => 'admins']);    
        
        // Permission
        Permission::create(['name' => 'show permissions', 'guard_name' => 'admin', 'section' => 'permissions']);
        Permission::create(['name' => 'store permission', 'guard_name' => 'admin', 'section' => 'permissions']);
        Permission::create(['name' => 'edit permission', 'guard_name' => 'admin', 'section' => 'permissions']);
        Permission::create(['name' => 'delete permission', 'guard_name' => 'admin', 'section' => 'permissions']);    
        
        // Roles
        Permission::create(['name' => 'show roles', 'guard_name' => 'admin', 'section' => 'roles']);
        Permission::create(['name' => 'store role', 'guard_name' => 'admin', 'section' => 'roles']);
        Permission::create(['name' => 'edit role', 'guard_name' => 'admin', 'section' => 'roles']);
        Permission::create(['name' => 'delete role', 'guard_name' => 'admin', 'section' => 'roles']);    
    }
}
