<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminsController extends Controller
{
    function __construct() {
        $this->middleware(['role:super admin']);
    }

    public function index() {
        
        $sections = Permission::select('section')->groupBy('section')->get();
        // dd($sections);
        $allPermissions = Permission::all();
        $allRoles = Role::all();
        $superAdmins = Admin::role('super admin')->count();
        $usernames = [];

        $keyword    = request()->input('keyword') != null ? request()->input('keyword') : null;
        $status     = request()->input('status') != null && in_array(request()->input('status'),['1', '0']) ? request()->input('status') : 'all';
        $constraints     = request()->input('constraints') != null && in_array(request()->input('constraints'),['0', '1', '2', '3']) ? request()->input('constraints') : '0';
        $sort_by    = request()->input('sort_by') != null && in_array(request()->input('sort_by'),['created_at', 'status', 'name', 'email']) ? request()->input('sort_by') : 'created_at';
        $order_by   = request()->input('order_by') != null && in_array(request()->input('order_by'),['asc', 'desc']) ? request()->input('order_by') : 'desc';
        $limit_by   = request()->input('limit_by') != null && in_array(request()->input('limit_by'),['10', '20', '50' ,'100']) ? request()->input('limit_by') : '20';
        $roles = [];
        if(request()->input('roles') != null){
            foreach(request()->input('roles') as $role ) {
                $roles[] = str_replace('_', ' ',$role); 
            }
        }
        $permissions = [];
        if(request()->input('permissions') != null){
            foreach(request()->input('permissions') as $permission ) {
                $permissions[] = str_replace('_', ' ',$permission); 
            }
        }
        $myRequest['roles'] = $roles;
        $myRequest['permissions'] = $permissions;
        $validator = Validator::make($myRequest, [
            'roles'     => 'nullable|array',
            'roles.*'   => 'exists:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name'
            ], [
            'roles.*.exists' => 'You added unexists roles',
            'permissions.*.exists' => 'You added unexists permissions',
        ]);
        if($validator->fails()) {            
            return redirect()->route('admin.admin.all')->with([
                'message' => 'You add unexist roles or permissions ',
                'alert-type' => 'danger',
            ]);
        }

        $allAdmins = Admin::where('admin', 1);
        if($keyword != null) {
            $allAdmins = $allAdmins->search($keyword, null, true);
        }   
        if($status !== 'all') {
            $allAdmins = $allAdmins->where('status', $status);
        }
        if( !(empty($roles) && empty($permissions)) ) {
            $usernames = spatieSearch($permissions, $roles, $constraints);
            $allAdmins = $allAdmins->whereIn('username', $usernames);
        }
        $allAdmins = $allAdmins->orderBy($sort_by, $order_by)->paginate($limit_by);

        return view('backend.admins.admins', [
            'allAdmins'    => $allAdmins,
            'sections'     => $sections,
            'allPermissions'  => $allPermissions,
            'allRoles'     => $allRoles,     
            'superAdmins' => $superAdmins   
        ]);
    }

    public function create()
    {
        $sections = Permission::select('section')->groupBy('section')->get();
        $permissions = Permission::all();
        $unDeletableRoles = Role::where('deletable',0)->get();
        $deletableRoles = Role::where('deletable',1)->get();
        //dd($deletableRoles->count() != 0);
        return view('backend.admins.create-admin', [
            'sections'          => $sections,
            'permissions'       => $permissions,
            'unDeletableRoles'  => $unDeletableRoles,
            'deletableRoles'    => $deletableRoles,
        ]);
    }

    public function store(Request $request)
    {

        $roles = [];
        if($request->input('roles') != null){
            foreach($request->input('roles') as $role ) {
                $roles[] = str_replace('_', ' ',$role); 
            }
        }

        $permissions = [];
        if($request->input('permissions') != null){
            foreach($request->input('permissions') as $permission ) {
                $permissions[] = str_replace('_', ' ',$permission); 
            }
        }
        // dd($request->all());
        $myRequest = $request->all();
        $myRequest['roles'] = $roles;
        $myRequest['permissions'] = $permissions;
        
        $validator = Validator::make($myRequest, [
            'name'      => 'required|string|min:5',
            'username'  => 'nullable|string|min:5|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'mobile'    => 'required|numeric|unique:users,mobile',
            'status'    => 'nullable|boolean',
            'bio'       => 'nullable|string|min:5',
            'image'     => 'image|mimes:jpg,jpeg,png',
            'password'  => 'required|confirmed',
            'roles'     => 'required_without:permissions|array',
            'roles.*'   => 'exists:roles,name',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,name'
            ], [
            'roles.required' => 'You must add one roles at least',
            'roles.*.exists' => 'You added unexists roles',
            'permissions.*.exists' => 'You added unexists permissions',
        ]);
        if($validator->fails()) {            
            return redirect()->route('admin.admin.create')->withErrors($validator)->withInput();
        }
        
        $data['name']   = $request->input('name');
        $data['username'] = $request->input('username') !== null ? $request->input('username') : Str::slug($request->input('name')) . '-' . rand(0,1000000);
        $data['email']  = $request->input('email');
        $data['mobile'] = $request->input('mobile');
        $data['status'] = $request->input('status');
        $data['admin']  = 1;
        $data['receive_email']  = $request->input('receive_email');
        $data['bio']    = $request->input('bio');
        $data['email_verified_at'] = Carbon::now();
        $data['password'] = bcrypt($request->input('password'));
        
        if($request->file('image') != null) {
            $data['user_image'] = $data['username'] . '-' . rand(0,1000000) . '.' . $request->file('image')->extension();
            $path = public_path('assets/users/' . $data['user_image']);
            Image::make($request->file('image')->getRealPath())->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            //dd($data);
        }

        $admin = Admin::create($data);
        if($admin) {

            if(!empty($roles)) {
                $admin->assignRole($roles);
            }
            if(!empty($permissions)) {
                /* foreach($permissions as $permission) {
                    $admin->givePermissionTo($permission);
                } */
                $admin->givePermissionTo($permissions);
            }

            return redirect()->route('admin.admin.create')->with([
                'message' => 'Admin created successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return redirect()->route('admin.admin.all')->with([
                'message' => 'Some thing was wrong! try later ',
                'alert-type' => 'danger',
            ]);
        } 
    
    }

    public function show($username)
    {
        $admin = Admin::where('username', $username)->where('admin',1)->first();
        $superAdmins = Admin::role('super admin')->count();
        if($admin) {
            $adminRoles = $admin->roles->pluck('name')->toArray();
            /*             $directPermissions = $admin->getDirectPermissions()->pluck('name')->toArray();
            
            $sections = Permission::select('section')->groupBy('section')->orderBy('created_at')->get();
            $permissions = Permission::all();
            $unDeletableRoles = Role::where('deletable',0)->get();
            $deletableRoles = Role::where('deletable',1)->get(); */

            return view('backend.admins.show-admin', [
                'admin'             => $admin,
                'adminRoles'        => $adminRoles,
                'superAdmins'       => $superAdmins
            ]);
        }else{
            return view('backend.404');
        }
    }

    public function edit($username)
    {
        $admin = Admin::where('username', $username)->where('admin',1)->first();

        if($admin) {
            $adminRoles = $admin->roles->pluck('name')->toArray();
            $directPermissions = $admin->getDirectPermissions()->pluck('name')->toArray();
            
            $sections = Permission::select('section')->groupBy('section')->get();
            $permissions = Permission::all();
            $unDeletableRoles = Role::where('deletable',0)->get();
            $deletableRoles = Role::where('deletable',1)->get();

            return view('backend.admins.edit-admin', [
                'admin'             => $admin,
                'adminRoles'        => $adminRoles,
                'directPermissions' => $directPermissions,
                'sections'          => $sections,
                'permissions'       => $permissions,
                'unDeletableRoles'  => $unDeletableRoles,
                'deletableRoles'    => $deletableRoles,
            ]);
        }else{
            return view('backend.404');
        }
    }

    public function update(Request $request, $username)
    {
        
        $admin = Admin::where('username', $username)->where('admin',1)->first();

        if($admin) {
            $roles = [];
            if($request->input('roles') != null){
                foreach($request->input('roles') as $role ) {
                    $roles[] = str_replace('_', ' ',$role); 
                }
            }
    
            $permissions = [];
            if($request->input('permissions') != null){
                foreach($request->input('permissions') as $permission ) {
                    $permissions[] = str_replace('_', ' ',$permission); 
                }
            }
            
            $myRequest = $request->all();
            $myRequest['roles'] = $roles;
            $myRequest['permissions'] = $permissions;

            $validator = Validator::make($myRequest, [
                'name'      => 'required|string|min:5',
                'username'  => ['nullable','string','min:5',
                                Rule::unique('users', 'username')->ignore($admin->id)],
                'email'     => ['required','email',
                                Rule::unique('users', 'email')->ignore($admin->id)],
                'mobile'    => ['required','numeric',
                                Rule::unique('users', 'mobile')->ignore($admin->id)],
                'status'    => 'nullable|boolean',
                'bio'       => 'nullable|string|min:5',
                'image'     => 'image|mimes:jpg,jpeg,png',
                'roles'     => 'required_without:permissions|array',
                'roles.*'   => 'exists:roles,name',
                'permissions'   => 'nullable|array',
                'permissions.*' => 'exists:permissions,name'
                ], [
                'roles.required' => 'You must add one roles at least',
                'roles.*.exists' => 'You added unexists roles',
                'permissions.*.exists' => 'You added unexists permissions',
            ]);
            if($validator->fails()) {
                return redirect()->route('admin.admin.edit', $admin->username)->withErrors($validator)->withInput();
            }
    
            $data['name']   = $request->input('name');

            if($request->input('username') !== null){
                $data['username'] = $request->input('username');
            }else{
                $data['username'] = Str::slug($request->input('name')) . '-' . rand(0,1000000);
                $username = Admin::where('username',$data['username'])->first();
                if($username) {
                    return redirect()->route('admin.user.edit', $admin->username)->withErrors(['username' => 'this username is used'])->withInput();
                }
            }

            $data['email']  = $request->input('email');
            $data['mobile'] = $request->input('mobile');
            $data['status'] = $request->input('status');
            $data['receive_email']  = $request->input('receive_email');
            $data['bio']    = $request->input('bio');
            
            if($request->file('image') != null) {
                $data['user_image'] = $data['username'] . '-' . rand(0,1000000) . '.' . $request->file('image')->extension();
                $path = public_path('assets/admins/' . $data['user_image']);
                Image::make($request->file('image')->getRealPath())->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                
                if(File::exists(public_path('assets/admins/' . $admin->user_image)) && $admin->user_image != null) {
                    unlink(public_path('assets/admins/' . $admin->user_image));
                }
            }
    
            if($admin->update($data)) {
                
                $admin->syncRoles($roles);
                $admin->syncPermissions($permissions);                

                return redirect()->route('admin.admin.edit', $data['username'])->with([
                    'message' => 'Admin updated successfully',
                    'alert-type' => 'success',
                ]);
            }else {
                return redirect()->route('admin.admin.all')->with([
                    'message' => 'Some thing was wrong! try later ',
                    'alert-type' => 'danger',
                ]);
            }

        }else{
            return view('backend.404');
        }        
    
    }
    
    public function editPassword($username)
    {
        $admin = Admin::where('username', $username)->where('admin',1)->first();

        if($admin) {

            return view('backend.admins.edit-password-admin', ['admin' => $admin]);

        }else{
            return view('backend.404');
        }        
    
    }

    public function updatePassword(Request $request, $username)
    {
        $admin = Admin::where('username', $username)->where('admin',1)->first();

        if($admin) {
            $validator = Validator::make($request->all(), [
                'password'  => 'required|confirmed',
            ]);
            if($validator->fails()) {
                return redirect()->route('admin.admin.edit.password', $admin->username)->withErrors($validator)->withInput();
            }
    
            $data['password'] = bcrypt($request->input('password'));
    
            if($admin->update($data)) {
                return redirect()->route('admin.admin.edit', $username)->with([
                    'message' => 'Password updated successfully',
                    'alert-type' => 'success',
                ]);
            }else {
                return redirect()->route('admin.admin.all')->with([
                    'message' => 'Some thing was wrong! try later ',
                    'alert-type' => 'danger',
                ]);
            }

        }else{
            return view('backend.404');
        }        
    
    }

    public function destroyImage($username)
    {
        $admin = Admin::where('username', $username)->where('admin',1)->first();

        if($admin) {
            if(File::exists(public_path('assets/admins/' . $admin->user_image)) && $admin->user_image != null) {
                unlink(public_path('assets/admins/' . $admin->user_image));
            }
            $data['user_image'] = null;
            if($admin->update($data)) {
                return redirect()->route('admin.admin.edit', $admin->username)->with([
                    'message' => 'Admin\'s photo deleted successfully',
                    'alert-type' => 'success',
                ]);
            }else {
                return redirect()->route('admin.admin.all')->with([
                    'message' => 'Some thing was wrong! try later ',
                    'alert-type' => 'danger',
                ]);
            }
        }else{
            return view('backend.404');
        }
    }

    public function destroy($username)
    {
        $admin = Admin::where('username', $username)->where('admin',1)->first();
        $superAdmins = Admin::role('super admin')->count();
        // dd($superAdmins);
        if($admin) {
            if($admin->hasRole('super admin') && $superAdmins < 2) {
                return redirect()->route('admin.admin.all')->with([
                    'message' => 'Must be at least one super admin',
                    'alert-type' => 'danger',
                ]);
            }
            if(File::exists(public_path('assets/admins/' . $admin->user_image) && $admin->user_image != null)) {
                unlink(public_path('assets/admins/' . $admin->user_image));
            }
            
            if($admin->delete()) {
                return redirect()->route('admin.admin.all')->with([
                    'message' => 'Admin deleted successfully',
                    'alert-type' => 'success',
                ]);
            }else {
                return redirect()->route('admin.admin.all')->with([
                    'message' => 'Some thing was wrong! try later ',
                    'alert-type' => 'danger',
                ]);
            }
        }else{
            return view('backend.404');
        }
    }

}
