<?php

use App\Models\Admin;
use Spatie\Valuestore\Valuestore;


function getSetting($key) {
    $valuestore = ValueStore::make(config_path('settings.json'));
    return $valuestore->get($key);
}

function spatieSearch($searchPermissions, $searchRoles, $type = '0') {

    function array_equal($a, $b) {
        return (
             is_array($a) 
             && is_array($b) 
             && count($a) == count($b) 
             && array_diff($a, $b) === array_diff($b, $a)
        );
    }

    $admins = Admin::where('admin', '1')->get();
    $adminsRoles = [];
    $adminsPermissions = [];
    $usernamePermissions = [];
    $usernameRoles = [];

    foreach($admins as $admin) {
        $adminsRoles[$admin->username] = $admin->roles->pluck('name')->toArray();
        $adminsPermissions[$admin->username] = $admin->getAllPermissions()->pluck('name')->toArray();
    }

    if($type === '0'){
        foreach($adminsRoles as $username => $role) {
            // أذا كانت سيرش رولز فاضية عندها سيعيد كل الأدمنز وكذك الأمر بالنسبة لسيرش بيرمشنز
            if( array_equal(array_intersect($searchRoles, $role), $searchRoles) ) {$usernameRoles[] = $username;}
        }
        foreach($adminsPermissions as $username => $permission) {
            if( array_equal(array_intersect($searchPermissions, $permission), $searchPermissions) ) {$usernamePermissions[] = $username;}
        }        
    }elseif($type === '1'){// exact roles
        foreach($adminsRoles as $username => $role) {
            if( array_equal($searchRoles, $role) ) {$usernameRoles[] = $username;}
        }
        foreach($adminsPermissions as $username => $permission) {
            if( array_equal(array_intersect($searchPermissions, $permission), $searchPermissions) ) {$usernamePermissions[] = $username;}
        }        
    }elseif($type === '2'){ // exact permissions
        foreach($adminsRoles as $username => $role) {
            if( array_equal(array_intersect($searchRoles, $role), $searchRoles) ) {$usernameRoles[] = $username;}
        }
        foreach($adminsPermissions as $username => $permission) {
            if( array_equal($searchPermissions, $permission) ) {$usernamePermissions[] = $username;}
        }        
    }elseif($type === '3'){ // exact roles and permissions
        foreach($adminsRoles as $username => $role) {
            if( array_equal($searchRoles, $role) ) {$usernameRoles[] = $username;}
        }
        foreach($adminsPermissions as $username => $permission) {
            if( array_equal($searchPermissions, $permission) ) {$usernamePermissions[] = $username;}
        }        
    } 
    
    return array_intersect($usernamePermissions,$usernameRoles);

}

function canAnyPermissions($permissions) {
    if(is_array($permissions)){
        foreach($permissions as $permission) {
            if(auth('admin')->user()->can($permission, 'admin')) return true;
        }
    }else{
        if(auth('admin')->user()->can($permissions, 'admin')) return true;
    }
    return false;
}