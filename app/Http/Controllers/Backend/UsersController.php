<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UsersController extends Controller
{

    public function index() {

        $keyword    = request()->input('keyword') != null ? request()->input('keyword') : null;
        $status     = request()->input('status') != null && in_array(request()->input('status'),['1', '0']) ? request()->input('status') : 'all';
        $sort_by    = request()->input('sort_by') != null && in_array(request()->input('sort_by'),['created_at', 'status', 'name', 'posts_count', 'email', 'username']) ? request()->input('sort_by') : 'created_at';
        $order_by   = request()->input('order_by') != null && in_array(request()->input('order_by'),['asc', 'desc']) ? request()->input('order_by') : 'desc';
        $limit_by   = request()->input('limit_by') != null && in_array(request()->input('limit_by'),['10', '20', '50' ,'100']) ? request()->input('limit_by') : '20';

        $allUsers = User::withCount('posts');
        // $allUsers = User::withCount('posts');

        if($keyword != null) {
            $allUsers = $allUsers->search($keyword, null, true);
        }   
        if($status !== 'all') {
            $allUsers = $allUsers->where('status', $status);
        }
        $allUsers = $allUsers->where('admin', 0)->orderBy($sort_by, $order_by)->paginate($limit_by);

        return view('backend.users.users', ['allUsers' => $allUsers]);
    }

    public function create()
    {
        return view('backend.users.create-user');
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|min:5',
            'username'  => 'nullable|string|min:5|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'mobile'    => 'required|numeric|unique:users,mobile',
            'status'    => 'nullable|boolean',
            'bio'       => 'nullable|string|min:5',
            'image'     => 'image|mimes:jpg,jpeg,png',
            'password'  => 'required|confirmed',
        ]);
        if($validator->fails()) {
            return redirect()->route('admin.user.create')->withErrors($validator)->withInput();
        }

        $data['name']   = $request->input('name');
        $data['username'] = $request->input('username') !== null ? $request->input('username') : Str::slug($request->input('name')) . '-' . rand(0,1000000);
        $data['email']  = $request->input('email');
        $data['mobile'] = $request->input('mobile');
        $data['status'] = $request->input('status');
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

        if(User::create($data)) {
            return redirect()->route('admin.user.create')->with([
                'message' => 'User created successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return redirect()->route('admin.user.all')->with([
                'message' => 'Some thing was wrong! try later ',
                'alert-type' => 'danger',
            ]);
        }
    
    }

    public function show($id)
    {
        //
    }

    public function edit($username)
    {
        $user = User::where('username', $username)->where('admin',0)->first();

        if($user) {
            return view('backend.users.edit-user', ['user' => $user]);
        }else{
            return view('backend.404');
        }
    }

    public function update(Request $request, $username)
    {
        $user = User::where('username', $username)->where('admin',0)->first();

        if($user) {
            $validator = Validator::make($request->all(), [
                'name'      => 'required|string|min:5',
                'username'  => ['nullable','string','min:5',
                                Rule::unique('users', 'username')->ignore($user->id)],
                'email'     => ['required','email',
                                Rule::unique('users', 'email')->ignore($user->id)],
                'mobile'    => ['required','numeric',
                                Rule::unique('users', 'mobile')->ignore($user->id)],
                'status'    => 'nullable|boolean',
                'bio'       => 'nullable|string|min:5',
                'image'     => 'image|mimes:jpg,jpeg,png',
            ]);
            if($validator->fails()) {
                return redirect()->route('admin.user.edit', $user->username)->withErrors($validator)->withInput();
            }
    
            $data['name']   = $request->input('name');

            if($request->input('username') !== null){
                $data['username'] = $request->input('username');
                }else{
                    $data['username'] = Str::slug($request->input('name')) . '-' . rand(0,1000000);
                    $username = User::where('username',$data['username'])->first();
                    if($username) {
                        return redirect()->route('admin.user.edit', $user->username)->withErrors(['username' => 'this username is used'])->withInput();
                    }
            }

            $data['email']  = $request->input('email');
            $data['mobile'] = $request->input('mobile');
            $data['status'] = $request->input('status');
            $data['receive_email']  = $request->input('receive_email');
            $data['bio']    = $request->input('bio');
            
            if($request->file('image') != null) {
                $data['user_image'] = $data['username'] . '-' . rand(0,1000000) . '.' . $request->file('image')->extension();
                $path = public_path('assets/users/' . $data['user_image']);
                Image::make($request->file('image')->getRealPath())->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                
                if(File::exists(public_path('assets/users/' . $user->user_image)) && $user->user_image != null) {
                    unlink(public_path('assets/users/' . $user->user_image));
                }
            }
    
            if($user->update($data)) {
                return redirect()->route('admin.user.edit', $data['username'])->with([
                    'message' => 'User updated successfully',
                    'alert-type' => 'success',
                ]);
            }else {
                return redirect()->route('admin.user.all')->with([
                    'message' => 'Some thing was wrong! try later ',
                    'alert-type' => 'danger',
                ]);
            }

        }else{
            return view('backend.404');
        }        
    
    }
    
    public function updatePassword(Request $request, $username)
    {
        $user = User::where('username', $username)->where('admin',0)->first();

        if($user) {
            $validator = Validator::make($request->all(), [
                'password'  => 'required|confirmed',
            ]);
            if($validator->fails()) {
                return redirect()->route('admin.user.edit', $user->username)->withErrors($validator)->withInput();
            }
    
            $data['password'] = bcrypt($request->input('password'));
    
            if($user->update($data)) {
                return redirect()->route('admin.user.edit', $username)->with([
                    'message' => 'Password updated successfully',
                    'alert-type' => 'success',
                ]);
            }else {
                return redirect()->route('admin.user.all')->with([
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
        $user = User::where('username', $username)->where('admin',0)->first();

        if($user) {
            if(File::exists(public_path('assets/users/' . $user->user_image)) && $user->user_image != null) {
                unlink(public_path('assets/users/' . $user->user_image));
            }
            $data['user_image'] = null;
            if($user->update($data)) {
                return redirect()->route('admin.user.edit', $user->username)->with([
                    'message' => 'User\'s photo deleted successfully',
                    'alert-type' => 'success',
                ]);
            }else {
                return redirect()->route('admin.user.all')->with([
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
        $user = User::where('username', $username)->where('admin',0)->first();

        if($user) {
            if(File::exists(public_path('assets/users/' . $user->user_image) && $user->user_image != null)) {
                unlink(public_path('assets/users/' . $user->user_image));
            }
            
            if($user->delete()) {
                return redirect()->route('admin.user.all')->with([
                    'message' => 'User deleted successfully',
                    'alert-type' => 'success',
                ]);
            }else {
                return redirect()->route('admin.user.all')->with([
                    'message' => 'Some thing was wrong! try later ',
                    'alert-type' => 'danger',
                ]);
            }
        }else{
            return view('backend.404');
        }
    }

}
