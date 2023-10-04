<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    
    public function index()
    {

        $keyword    = request()->input('keyword') != null ? request()->input('keyword') : null;
        $deletable     = request()->input('deletable') != null && in_array(request()->input('deletable'),['1', '0']) ? request()->input('deletable') : 'all';
        $sort_by    = request()->input('sort_by') != null && in_array(request()->input('sort_by'),['name', 'guard_name']) ? request()->input('sort_by') : 'created_at';
        $order_by   = request()->input('order_by') != null && in_array(request()->input('order_by'),['asc', 'desc']) ? request()->input('order_by') : 'desc';
        $limit_by   = request()->input('limit_by') != null && in_array(request()->input('limit_by'),['10', '20', '50' ,'100']) ? request()->input('limit_by') : '20';

        $roles = Role::query();
        if($keyword != null) {
            $roles = $roles->search($keyword, null, true);
        }
        if($deletable !== 'all') {
            $roles = $roles->where('deletable', $deletable);
        }
        $roles = $roles->orderBy($sort_by, $order_by)->paginate($limit_by);

        return view('backend.roles.roles', ['roles' => $roles]);
    }

    
    public function create()
    {        
        $sections = Permission::select('section')->groupBy('section')->get();
        $permissions = Permission::all();
        return view('backend.roles.create-role', ['sections' => $sections, 'permissions' => $permissions]);
    }

    
    public function store(Request $request)
    {
        
        $permissions = [];
        foreach($request->except(['_token','name']) as $permission => $value) {
            $permissions[] = str_replace('_', ' ',$permission); 
        }
        $inputs['permissions'] = $permissions;
        $inputs['name'] = $request->input('name');
        
        $validator = Validator::make($inputs,[
            'name' => 'required|string|min:5',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,name'
        ], [
            'permissions.required' => 'You must add one permission at least',
            'permissions.*.exists' => 'You added unexists permissions',

        ]);
        if($validator->fails()){
            return redirect()->route('admin.role.create')->withInput()->withErrors($validator);
        }

        $role = Role::create(['name' => $inputs['name'], 'guard_name' => 'admin']);
        if($role){
            foreach($permissions as $permission) {
                $role->givePermissionTo(Permission::where('name', $permission)->first());
            }
        }

        return redirect()->route('admin.role.all')->with([
            'message' => 'Role added successfully',
            'alert-type' => 'success',
        ]);
        
    }

    
    public function show($id)
    {
        $role = Role::where('id', $id)->first();
        if($role) {
            
            $permissionsName = [];
            foreach($role->permissions as $permission){
                $permissionsName[] = $permission->name;
            }

            $sections = Permission::select('section')->groupBy('section')->orderBy('created_at')->get();
            $permissions = Permission::all();
            

            return view('backend.roles.show-role', [
                'sections'          => $sections,
                'permissions'       => $permissions,
                'permissionsName'   => $permissionsName,
                'role'              => $role]);
        }else {
            return view('backend.404');
        }
    }

    
    public function edit($id)
    {
        $role = Role::where('id', $id)->where('deletable', 1)->first();
        if($role) {
            
            $permissionsName = [];
            foreach($role->permissions as $permission){
                $permissionsName[] = $permission->name;
            }

            $sections = Permission::select('section')->groupBy('section')->get();
            $permissions = Permission::all();
            

            return view('backend.roles.edit-role', [
                'sections'          => $sections,
                'permissions'       => $permissions,
                'permissionsName'   => $permissionsName,
                'role'              => $role]);
        }else {
            return view('backend.404');
        }
    }

    
    public function update(Request $request, $id)
    {
        $role = Role::where('id', $id)->where('deletable', 1)->first();
        if($role) {

            $permissions = [];
            foreach($request->except(['_token','name', '_method']) as $permission => $value) {
                $permissions[] = str_replace('_', ' ',$permission); 
            }
            $inputs['permissions'] = $permissions;
            $inputs['name'] = $request->input('name');
            
            $validator = Validator::make($inputs,[
                'name' => 'required|string|min:5',
                'permissions' => 'required|array|min:1',
                'permissions.*' => 'exists:permissions,name'
            ], [
                'permissions.required' => 'You must add one permission at least',
                'permissions.*.exists' => 'You added unexists permissions',
    
            ]);
            if($validator->fails()){
                return redirect()->route('admin.role.edit', $role->id)->withInput()->withErrors($validator)->with(['updateFailed'=>'yes']);
            }

            $role->syncPermissions(Permission::whereIn('name', $permissions)->get());

            return redirect()->route('admin.role.edit', $role->id)->with([
                'message' => 'Role updated successfully',
                'alert-type' => 'success',
            ]);

        }else {
            return view('backend.404');
        }
    }

    
    public function destroy($id)
    {
        $role = Role::where('id', $id)->where('deletable', 1)->first();
        if($role) {
            if($role->delete()) {
                return redirect()->route('admin.role.all')->with([
                    'message' => 'Role deleted successfully',
                    'alert-type' => 'success',
                ]);
            }else {
                return redirect()->route('admin.role.all')->with([
                    'message' => 'Some thing was wrong! try later ',
                    'alert-type' => 'danger',
                ]);
            }
        }else {
            return view('backend.404');
        }
    }
}
