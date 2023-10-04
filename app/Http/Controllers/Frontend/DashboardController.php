<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use illuminate\support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class DashboardController extends Controller
{
    public function index() {

        $posts = auth()->user()->posts()->withCount('comments')
                    ->whereHas('category', function($query) {
                        $query->where('status', 1);
                    })->orderBy('created_at', 'DESC')->limit(7)->get();
        
        $comments = Comment::with(['user', 'post'])->whereHas('post', function($query) {
            $query->where('user_id', auth()->user()->id)->where('post_type', 'post')->where('status', 1);
        })->orderBy('created_at', 'DESC')->limit(7)->get();

        $comments_count = 0;
        foreach(auth()->user()->posts()->get() as $post) {
            $comments_count += $post->comments()->count();
        }
        // dd($comments_count);
        return view('frontend.user.dashboard', ['posts' => $posts, 'comments' => $comments, 'comments_count' => $comments_count ]);
    }

    public function allPosts() {

        $status = request()->input('status') != null && in_array(request()->input('status'),['1', '0']) ? request()->input('status') : 'all';
        
        $posts = auth()->user()->posts()->withCount('comments')
                    ->whereHas('category', function($query) {
                        $query->where('post_type', 'post');
                    });
        if($status != 'all') {
            $posts = $posts->where('status', $status);
        }
                    
        $posts =$posts->orderBy('created_at', 'DESC')->paginate(10);

        return view('frontend.user.posts', ['posts' => $posts, 'status' => $status]);
    }

    public function createPost() {
        $allCategories = Category::where('status', 1)->get();
        return view('frontend.user.post-create', ['allCategories' => $allCategories]);
    }

    public function storePost(Request $request) {
        //dd($request->all());
        $validator = Validator::make($request->all(),[
            'title'         => 'required|string|min:10',
            'description'   => 'required|string|min:100',
            'status'        => 'required|boolean',
            'category'      => 'required|exists:categories,id',
            'Comment_able'  => 'required|boolean',
            'post_cover'    => 'nullable|mimes:jpg,bmp,png|max:4097',
            'images'        => 'nullable',
            'images.*'      => 'nullable|mimes:jpg,bmp,png|max:4097',
        ], [
            'images.*.mimes'      => 'You must add only images files',
            'images.*.max'      => 'Image size must be less than 4MB',
        ]);

        if($validator->fails()){
            return redirect()->route('dashboard.createPost')->withErrors($validator)->withInput();
        }

        $data['title']          = $request->input('title');
        $data['slug']           = Str::slug($request->input('title'));
        $data['description']    = $request->input('description');
        $data['status']         = $request->input('status');
        $data['Comment_able']   = $request->input('Comment_able');
        $data['category_id']    = $request->input('category');        

        if($request->file('post_cover') != null) {
            $filename = $data['slug'] . '-' . time() . '-post-cover.' . $request->file('post_cover')->getClientOriginalExtension();           
            
            $path = public_path('/assets/posts/' . $filename);
            Image::make($request->file('post_cover')->getRealPath())->resize(1170, 788, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $data['post_cover'] = $filename; 
        }

        $post = auth()->user()->posts()->create($data);
        // إضافة الصور التي تكون ضمن المقال الى قاعدة البيانات وحفظها في مجلد الصور الخاص بها
        if($request->file('images') != null && count($request->file('images')) > 0) {
            $loop = 1;
            foreach( $request->file('images') as $file) {

                $filename = $post->slug . '-' . time() . '-' . $loop . '.' . $file->getClientOriginalExtension();                
                $file_type = $file->getClientMimeType();
                $path = public_path('/assets/posts/' . $filename);
                $img = Image::make($file->getRealPath())->resize(1170, 788, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $file_size = $img->filesize();

                $post->media()->create([
                    'file_name' => $filename,
                    'file_type' => $file_type,
                    'file_size' => $file_size 
                ]);
                $loop++;
            }
        }

        if ($request->status == 1) {
            Cache::forget('recent_posts');
        }

        return redirect()->route('dashboard.home')->with([
            'message' => 'Post created successfully',
            'alert-type' => 'success',
        ]);      

    }

    public function editPost($slug) {
        $post = auth()->user()->posts()->where('slug', $slug)->first();
        if($post) {
            $allCategories = Category::where('status', 1)->get();
            return view('frontend.user.post-edit', ['allCategories' => $allCategories, 'post' => $post]);
        }else {
            return redirect()->route('dashboard.home')->with([
                'message' => 'Post was not found',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function updatePost(Request $request) {

        $post = Post::where('slug', $request->input('slug'))->where('user_id', auth()->user()->id)->first();
        if($post) {

            $validator = Validator::make($request->all(),[
                'title'         => 'required|string|min:10',
                'description'   => 'required|string|min:100',
                // 'status'        => 'required|boolean',
                'category'      => 'required|exists:categories,id',
                'Comment_able'  => 'required|boolean',
                'images[]'      => 'nullable|image|mimes:jpg,bmp,png|max:4097',
            ]);
    
            if($validator->fails()){
                return redirect()->route('dashboard.editPost', $post->slug)->withErrors($validator)->withInput();
            }
    
            $data['title']          = $request->input('title');
            $data['slug']           = Str::slug($request->input('title'));
            $data['description']    = $request->input('description');
            // $data['status']         = $request->input('status');
            $data['Comment_able']   = $request->input('Comment_able');
            $data['category_id']    = $request->input('category');

            if($request->file('post_cover') != null) {
                $filename = $data['slug'] . '-' . time() . '-post-cover.' . $request->file('post_cover')->getClientOriginalExtension();           
                // إضافة صورة الكفر الجديدية
                $path = public_path('/assets/posts/' . $filename);
                Image::make($request->file('post_cover')->getRealPath())->resize(1170, 788, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                // حذف صورة الكفر القديمة
                if(File::exists(public_path('assets/posts/' . $post->post_cover)) && $post->post_cover != null ) {
                    unlink(public_path('assets/posts/' . $post->post_cover));
                }
                $data['post_cover'] = $filename; 
            }
            // تحديث جدول البوستس بالبيانات الجديدة
            $post->update($data);
    
            if($request->file('images') != null && count($request->file('images')) > 0) {
                //dd($request->file('images'));
                $loop = 1;
                foreach( $request->file('images') as $file) {
    
                    $filename = $data['slug'] . '-' . time() . '-' . $loop . '.' . $file->getClientOriginalExtension();                   
                    $file_type = $file->getClientMimeType();
                    $path = public_path('/assets/posts/' . $filename);
                    $img = Image::make($file->getRealPath())->resize(1170, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);
                    $file_size = $img->filesize();
    
                    $post->media()->create([
                        'file_name' => $filename,
                        'file_type' => $file_type,
                        'file_size' => $file_size 
                    ]);
                    $loop++;
                }
            }
    
            if ($request->status == 1) {
                Cache::forget('recent_posts');
            }
    
            return redirect()->route('dashboard.editPost', $data['slug'])->with([
                'message' => 'Post updated successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return redirect()->route('dashboard.home')->with([
                'message' => 'Post was not found',
                'alert-type' => 'danger',
            ]);
        }

    }
   
    public function destroyPost($slug) {
        $post = Post::with(['media'])->where('slug', $slug)->where('user_id', auth()->user()->id)->first();
        if($post) {    

            if($post->media->count() > 0) {
                foreach($post->media as $media){
                    if(File::exists(public_path('assets/posts/' . $media->file_name))){
                        unlink(public_path('assets/posts/' . $media->file_name));
                    }
                }
            }
            $post->delete();
            return redirect()->back()->with([
                'message' => 'Post deleted successfully',
                'alert-type' => 'success',
            ]);

        }else {
            return redirect()->route('dashboard.home')->with([
                'message' => 'Post was not found',
                'alert-type' => 'danger',
            ]);
        }
    }    

    public function destroyImage($media_id) {

        $media = PostMedia::with(['post'])->whereHas('post', function($query) {
            $query->where('user_id', auth()->user()->id);
            })->where('id', $media_id)->first();
            if($media) {
                if(File::exists(public_path('assets/posts/' . $media->file_name))){
                    unlink(public_path('assets/posts/' . $media->file_name));
                }
                $slug= $media->post->slug;
                $media->delete();
                return redirect()->route('dashboard.editPost', $slug);
            }else {
                return redirect()->route('notFound');
            }

    }  
    
    public function allComments() {

        $comments = Comment::with(['user', 'post'])->whereHas('post', function($query) {
            $query->whereIn('id', auth()->user()->posts()->pluck('id'))->where('post_type', 'post')->where('status', 1);
        })->orderBy('created_at', 'DESC')->paginate(10);
        // dd(auth()->user()->posts()->pluck('id')->toArray());
        return view('frontend.user.comments', ['comments' => $comments ]);
    }

    public function editComment($id, $action) {
        // dd(request()->input('page'));
        $comment = Comment::where('id', $id)->whereHas('post', function($query) {
            $query->where('user_id', auth()->user()->id)->where('post_type', 'post')->where('status', 1);
        })->first();
        if($comment && in_array($action, ['disapprove', 'approve'])) {
            if($action == 'disapprove'){
                $comment->update([
                    'status' => 0,
                ]);
            }elseif($action == 'approve') {
                $comment->update([
                    'status' => 1,
                ]);
            }
            // return redirect()->route('dashboard.allComments', ['page' => request('page')])->with([
            return redirect()->back()->with([
                'message' => 'Comment\'s status changed successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return redirect()->route('notFound');
        }

       
    }
    public function myInformation() {
        $user = auth()->user();
        return view('frontend.user.my-information', ['user' => $user]);
    }

    public function updateMyInformation(Request $request) {

        $validator = Validator::make($request->all(),[
            'name'          => 'required',
            'username'      => ['required',
                                Rule::unique('users','username')->ignore(auth()->user()->id, 'id')],
            'email'         => 'required|email',
            'mobile'        => 'required|numeric',
            'bio'           => 'nullable|string|min:10',
            'receive_email' => 'required|boolean',
            'user_image'    => 'nullable|image|mimes:jpg,bmp,png|max:4097',  
            'cover_image'    => 'nullable|image|mimes:jpg,bmp,png|max:4097'  
        ]);

        if($validator->fails()){
            return redirect()->route('dashboard.myInformation')->withErrors($validator)->withInput();
        };


        $data['name']           = $request->name;
        $data['username']       = $request->username;
        $data['email']          = $request->email;
        $data['mobile']         = $request->mobile;
        $data['bio']            = $request->bio;
        $data['receive_email']  = $request->receive_email;

        $image = $request->file('user_image');
        $cover = $request->file('cover_image');
        
        if( $image !== null) {
            if (auth()->user()->user_image != ''){
                if (File::exists('/assets/users/' . auth()->user()->user_image)){
                    unlink('/assets/users/' . auth()->user()->user_image);
                }
            }
        
            $filename = Str::slug(auth()->user()->username).'.'.$image->getClientOriginalExtension();
            $path = public_path('assets/users/' . $filename);
            Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $data['user_image'] = $filename;
        }

        if( $cover !== null) {
            if (auth()->user()->cover_image != ''){
                if (File::exists(public_path('/assets/covers/' . auth()->user()->cover_image))){
                    unlink(public_path('/assets/covers/' . auth()->user()->cover_image));
                }
            }
            $filename = Str::slug(auth()->user()->username).'.'.$cover->getClientOriginalExtension();
            $path = public_path('assets/covers/' . $filename);
            Image::make($cover->getRealPath())->resize(1920,1285, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $data['cover_image'] = $filename;
        }

        $update = auth()->user()->update($data);

        if ($update) {
            return redirect()->route('dashboard.myInformation')->with([
                'message' => 'Information updated successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->route('dashboard.myInformation')->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function destroyUserImage($type) {
        if($type == 'profile') {
            //حذف صورة المستخدم
            if (auth()->user()->user_image != null){
                if (File::exists(public_path('/assets/users/' . auth()->user()->user_image))){
                    unlink(public_path('/assets/users/' . auth()->user()->user_image));
                }
            }
            $update = auth()->user()->update(['user_image' => null]);
        }elseif($type == 'cover') {
            // حذف الكوفر الخاص بالمستخدم
            if (auth()->user()->cover_image != null){
                if (File::exists(public_path('/assets/covers/' . auth()->user()->cover_image))){
                    unlink(public_path('/assets/covers/' . auth()->user()->cover_image));
                }
            }
            $update = auth()->user()->update(['cover_image' => null]);    
        }else {
            return redirect()->route('notFound');
        }

        if ($update) {
            return redirect()->route('dashboard.myInformation')->with([
                'message' => 'Photo deleted successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->route('dashboard.myInformation')->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }
    
    public function updatePassword(Request $request) {

        $validator = Validator::make($request->all(), [
            'current_password'  => 'required|current_password',
            'password'          => 'required|confirmed'
            // منو لحالو اللارافيل رح يعرف انو في حقل أدخال اسمو باسورد كونفورمشن
            // ولازم يطايق مع حقل الباسوورد
            // كل هاد بفضل كلمة confirmed
        ]);
        if($validator->fails()) {
            return redirect()->route('dashboard.myInformation')->withErrors($validator)->withInput();
        }

        $update = auth()->user()->update([
            'password' => bcrypt($request->password),
        ]);

        if ($update) {
            return redirect()->route('dashboard.myInformation')->with([
                'message' => 'Password updated successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->route('dashboard.myInformation')->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    } 

}
