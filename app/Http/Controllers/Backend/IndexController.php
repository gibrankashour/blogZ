<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class IndexController extends Controller
{

    public function index() {
        // return view('backend.dashboard');
        $timeBefore = strtotime('-6day', time());
        $timeSuitedForSearch = date('Y-m-d',mktime(0,0,0,date('m',$timeBefore),date('d',$timeBefore),date('Y',$timeBefore))) . ' 00:00:00';

        $postsPerCategory = Post::select(DB::raw("count(*) as count"), 'category_id')
        ->where('post_type', 'post')
        ->where('created_at', '>', $timeSuitedForSearch)
        ->groupBy('category_id')->limit(5)->get();

        $sum =0;
        $categoriesPercent = [];
        foreach($postsPerCategory as $category) {
            $sum += $category->count;
        }
        foreach($postsPerCategory as $category) {
            $categoriesPercent[] = [
                'category' => Category::where('id',$category->category_id)->first()->name,
                'percent' =>round(($category->count * 100) / $sum),
                'count' => $category->count
            ];
        }

        $latestPost = Post::with(['media'])->Where('post_type', 'post')->OrderBy('id','desc')->limit(1)->first();

        $latestFivePosts = Post::where('post_type', 'post')->withCount('comments')->OrderBy('created_at','desc')->limit(5)->get();
        $latestFiveComments = Comment::with(['post'])->limit(5)->get();

        $totalPosts = Post::count();
        $totalPendingPosts = Post::where('status', 0)->count();
        $totalUsers = User::count();
        $totalPendingUsers = User::where('status', 0)->count();


        return view('backend.dashboard', [
            'categoriesPercent' => $categoriesPercent,
            'latestPost'        => $latestPost,
            'latestFivePosts'   => $latestFivePosts,
            'latestFiveComments' => $latestFiveComments,
            'totalPosts'        => $totalPosts,
            'totalPendingPosts' => $totalPendingPosts,
            'totalUsers'        => $totalUsers,
            'totalPendingUsers' => $totalPendingUsers,
        ]);
    }

    public function search($type = 'all') {
        // dd(request()->input('search'));
        $validator = Validator::make(request()->all(), [
            'search'      => 'required|string|min:5',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $search = request()->input('search');
        $posts      = Post::where('post_type', 'post')->search($search, null, true)->orderBy('created_at','desc')->limit(5)->get();
        $comments   = Comment::search($search, null, true)->orderBy('created_at','desc')->limit(10)->get();
        $users      = User::withCount('posts')->where('admin', '0')->search($search, null, true)->orderBy('created_at','desc')->limit(6)->get();

        return view('backend.search')->with([
            'posts' =>$posts,
            'comments'=>$comments,
            'users'=>$users
        ]);
    }

    public function profile()
    {
        $admin = auth()->guard('admin')->user();

        $adminRoles = $admin->roles->pluck('name')->toArray();
        $directPermissions = $admin->getDirectPermissions()->pluck('name')->toArray();
        
        $sections = Permission::select('section')->groupBy('section')->get();
        $permissions = Permission::all();
        $unDeletableRoles = Role::where('deletable',0)->get();
        $deletableRoles = Role::where('deletable',1)->get();

        return view('backend.profile.profile', [
            'admin'             => $admin,
            'adminRoles'        => $adminRoles,
            'directPermissions' => $directPermissions,
            'sections'          => $sections,
            'permissions'       => $permissions,
            'unDeletableRoles'  => $unDeletableRoles,
            'deletableRoles'    => $deletableRoles,
        ]);

    }

    public function edit() {
        return view('backend.profile.edit-profile');
    }

    public function update(Request $request) {

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|min:5',
            'username'  => ['required','string','min:5',
                            Rule::unique('users', 'username')->ignore(auth()->user()->id)],
            'email'     => ['required','email',
                            Rule::unique('users', 'email')->ignore(auth()->user()->id)],
            'mobile'    => ['required','numeric',
                            Rule::unique('users', 'mobile')->ignore(auth()->user()->id)],
            'status'    => 'nullable|boolean',
            'bio'       => 'nullable|string|min:5',
            'image'     => 'image|mimes:jpg,jpeg,png',
        ]);
        if($validator->fails()) {
            return redirect()->route('admin.profile.edit')->withErrors($validator)->withInput();
        }

        $data['name']   = $request->input('name');
        $data['username'] = $request->input('username');
        $data['email']  = $request->input('email');
        $data['mobile'] = $request->input('mobile');
        $data['status'] = $request->input('status');
        $data['receive_email']  = $request->input('receive_email');
        $data['bio']    = $request->input('bio');
        // dd($data);
        if($request->file('image') != null) {
            $data['user_image'] = $data['username'] . '-' . rand(0,1000000) . '.' . $request->file('image')->extension();
            $path = public_path('assets/admins/' . $data['user_image']);
            Image::make($request->file('image')->getRealPath())->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            
            if(File::exists(public_path('assets/admins/' . auth('admin')->user()->user_image)) && auth('admin')->user()->user_image != null) {
                unlink(public_path('assets/admins/' . auth('admin')->user()->user_image));
            }
        }

        if(auth('admin')->user()->update($data)) {
            return redirect()->route('admin.profile')->with([
                'message' => 'Your information updated successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return redirect()->route('admin.home')->with([
                'message' => 'Some thing was wrong! try later ',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function destroyImage() {

        if(File::exists(public_path('assets/admins/' . auth()->user()->user_image)) && auth()->user()->user_image != null) {
            unlink(public_path('assets/admins/' . auth()->user()->user_image));
        }
        $data['user_image'] = null;
        if(auth()->user()->update($data)) {
            return redirect()->route('admin.profile')->with([
                'message' => 'You profile photo deleted successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return redirect()->route('admin.home')->with([
                'message' => 'Some thing was wrong! try later ',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function updatePassword(Request $request) {

        $validator = Validator::make($request->all(), [
            'password'  => 'required|confirmed',
            'old_password' => 'required|current_password:admin',
        ]);
        if($validator->fails()) {
            return redirect()->route('admin.profile')->withErrors($validator)->withInput();
        }

        $data['password'] = bcrypt($request->input('password'));

        if(auth()->user()->update($data)) {
            return redirect()->route('admin.profile')->with([
                'message' => 'Password updated successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return redirect()->route('admin.home')->with([
                'message' => 'Some thing was wrong! try later ',
                'alert-type' => 'danger',
            ]);
        }
    }
}
