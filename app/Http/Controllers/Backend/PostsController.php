<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function index() {

        $categories = Category::get();
        $users = User::get();

        $category   = request()->input('category') != null && in_array(request()->input('category'),$categories->pluck(['id'])->toArray()) ? request()->input('category') : 'all';
        $user       = request()->input('user') != null && in_array(request()->input('user'),$users->pluck(['id'])->toArray()) ? request()->input('user') : 'all';
        $status     = request()->input('status') != null && in_array(request()->input('status'),['1', '0']) ? request()->input('status') : 'all';
        $keyword    = request()->input('keyword') != null ? request()->input('keyword') : null;
        $sort_by    = request()->input('sort_by') != null && in_array(request()->input('sort_by'),['title', 'user', 'category', 'created_at', 'status', 'comments_count']) ? request()->input('sort_by') : 'created_at';
        $order_by   = request()->input('order_by') != null && in_array(request()->input('order_by'),['asc', 'desc']) ? request()->input('order_by') : 'desc';
        $limit_by   = request()->input('limit_by') != null && in_array(request()->input('limit_by'),['10', '20', '50' ,'100']) ? request()->input('limit_by') : '20';

        $allPosts = Post::with(['user', 'category'])->withCount('comments')->where('post_type', 'post')
                ->join('users','users.id','=','posts.user_id')
                ->join('categories','categories.id','=','posts.category_id')
                ->select('posts.*','categories.name as category_name','users.name as user_name');

        if($keyword != null) {
            $allPosts = $allPosts->search($keyword, null, true);
        }   
        if($category !== 'all') {
            $allPosts = $allPosts->where('category_id', $category);
        }
        if($user !== 'all') {
            $allPosts = $allPosts->where('user_id', $user);
        }
        if($status !== 'all') {
            $allPosts = $allPosts->where('posts.status', $status);
        }

        if($sort_by == 'user'){
            $allPosts = $allPosts->orderBy('user_name', $order_by);
        }elseif($sort_by == 'category') {
            $allPosts = $allPosts->orderBy('category_name', $order_by);
        }else {
            $allPosts = $allPosts->orderBy('posts.'.$sort_by, $order_by);
        }

        $allPosts = $allPosts->paginate($limit_by);
          
        return view('backend.posts.posts', [
            'allPosts'   => $allPosts,
            'allCategories' => $categories,
            'users'      => $users,
        ]);
    }

    public function create() {
        $categories = Category::get();

        return view('backend.posts.create-post')->with([
            'allCategories' => $categories
        ]);
    }

    public function store(Request $request) {
        // dd(auth('admin')->user());
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
            return redirect()->route('admin.post.create')->withErrors($validator)->withInput();
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

        $post = auth('admin')->user()->posts()->create($data);
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

        return redirect()->route('admin.post.all')->with([
            'message' => 'Post created successfully',
            'alert-type' => 'success',
        ]);      

    }

    public function show($slug){
        $post = Post::where('slug', $slug)->where('post_type', 'post')->first();
        $notes = null;

        if($post) {
            if($post->status == 0){
                $notes[] = 'Post status is 0'; 
            }
            if($post->user->status == 0){
                $notes[] = 'User status is 0';
            }
            if($post->category->status == 0){
                $notes[] = 'Category status is 0';
            }
            // عرض الصور ضمن البوست
            if(!empty($post)) {
                $descriptionArray = explode('[img][/img]', $post->description);        
                $description = $post->description;
                $index = 0;
                if(!empty($post->media)) {
                    foreach($post->media->pluck('file_name')->toArray() as $media) {
                        $descriptionArray[$index] = $descriptionArray[$index] . '<img src="'.asset('assets/posts/'. $media)  . '" alt="">';
                        $index++;
                    }
                    $description = implode('', $descriptionArray);
                }
            }
            // مهاية عرض الصور ضمن البوست
            return view('backend.posts.show-post', [
                'post' => $post,   
                'notes' => $notes,
                'description' => $description             
            ]);
        }else {
            return view('backend.404');
        }
    }

    public function status($slug, $status) {
        $post = Post::where('slug', $slug)->where('post_type', 'post')->first();
        
        if($post) {
            if($status == 'disapprove') {
                $post->update([
                    'status' => 0
                ]);
            }elseif($status == 'approve') {
                $post->update([
                    'status' => 1
                ]);
            }else{
                return view('backend.404');
            }
            return redirect()->back()->with([
                'message' => 'Post status changed successfully',
                'alert-type' => 'success'
            ]);
        }else {
            return view('backend.404');
        }
    }

    public function edit($slug) {
        $post = Post::where('slug', $slug)->where('post_type', 'post')->first();
        $categories = Category::get();
        if($post) {
            if(!$post->user->isAdmin()) {
                return redirect()->route('admin.post.all')->with([
                    'message' => 'Only the auther of this post can edit it!',
                    'alert-type' => 'danger',
                ]);                
            }
            return view('backend.posts.edit-post', [
                'post' => $post,
                'allCategories' => $categories
            ]);
        }else {
            return view('backend.404');
        }
    }
    
    public function update(Request $request, $slug) {
        $post = Post::where('slug', $slug)->where('post_type', 'post')->first();
        
        if($post) {
            if(!$post->user->isAdmin()) {
                return redirect()->route('admin.post.all')->with([
                    'message' => 'Only the auther of this post can edit it!',
                    'alert-type' => 'danger',
                ]);                
            }

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
                return redirect()->route('admin.post.edit', $slug)->withErrors($validator)->withInput();
            }
    
            $data['title']          = $request->input('title');
            $data['slug']           = Str::slug($request->input('title'));
            $data['description']    = $request->input('description');
            $data['status']         = $request->input('status');
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


            return redirect()->route('admin.post.edit', $data['slug'])->with([
                'message' => 'Post updated successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return view('backend.404');
        }
    }

    public function cover($slug) {
        $post = Post::where('slug', $slug)->where('post_type', 'post')->first();
        
        if($post) {
            if(!$post->user->isAdmin()) {
                return redirect()->route('admin.post.all')->with([
                    'message' => 'Only the auther of this post can edit it!',
                    'alert-type' => 'danger',
                ]);                
            }
            if(File::exists(public_path('assets/posts/'. $post->post_cover)) && $post->post_cover != null){
                unlink(public_path('assets/posts/'. $post->post_cover));
                $post->update([
                    'post_cover' => null
                ]);
            }
            return redirect()->route('admin.post.edit', $post->slug)->with([
                'message' => 'Post cover deleted successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return view('backend.404');
        }
    }

    public function image($slug, $media_id) {
        $media = PostMedia::where('id', $media_id)->whereHas('post', function($query) use($slug){
            $query->where('slug', $slug);
        })->first();
        if($media) {
            if(!$media->post->user->isAdmin()) {
                return redirect()->route('admin.post.all')->with([
                    'message' => 'Only the auther of this post can edit it!',
                    'alert-type' => 'danger',
                ]);                
            }
            if(File::exists(public_path('assets/posts/'. $media->file_name)) && $media->file_name != null){
                unlink(public_path('assets/posts/'. $media->file_name));
                $media->delete();
            }
            return redirect()->route('admin.post.edit', $media->post->slug)->with([
                'message' => 'Post image deleted successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return view('backend.404');
        }
    }

    public function destroy($slug) {
        $post = Post::where('slug', $slug)->where('post_type', 'post')->first();
        
        if($post) {
            if(!$post->user->isAdmin()) {
                return redirect()->route('admin.post.all')->with([
                    'message' => 'Only the auther of this post can edit it!',
                    'alert-type' => 'danger',
                ]);                
            }
            if(File::exists(public_path('assets/posts/'. $post->post_cover)) && $post->post_cover != null){
                unlink(public_path('assets/posts/'. $post->post_cover));
            }
            foreach($post->media as $media) {
                if(File::exists(public_path('assets/posts/'. $media->file_name)) && $media->file_name != null){
                    unlink(public_path('assets/posts/'. $media->file_name));
                } 
            }
            $post->delete();
            return redirect()->route('admin.post.all')->with([
                'message' => 'Post deleted successfully',
                'alert-type' => 'success',
            ]);
        }else {
            return view('backend.404');
        }
    }
}
