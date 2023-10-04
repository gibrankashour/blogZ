<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\contactStored;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{

    public function index() {

        // \Illuminate\Support\Facades\DB::statement("SET SQL_MODE=''");
        $posts = Post::with(['media'])->whereHas('user', function($query) {
                            $query->where('status', 1);
                        })->whereHas('category', function($query) {
                            $query->where('status', 1);
                        })
                        ->where('status', 1)->where('post_type', 'post');

        if(isset(request()->search) && request()->search != null) {
            $posts = $posts->search(request()->search, null, true);
        }

        $posts = $posts->orderBy('updated_at', 'DESC')->paginate(7);

        // إرسال معلومات البحث الى الصفحة لعرضها في الباجينيشن
        if(isset(request()->search) && request()->search != null) {
            $posts->appends(['search' => request()->search]);
        }
        return view('frontend.index',['posts' => $posts]);
    }

    public function postShow($slug) {
        // dd(request()->all());
        $post = Post::with(['media', 'approvedParentComments', 'category', 'user'])
                        ->withCount('approvedComments');
        
        $post = $post->whereHas('user', function($query) {
            $query->where('status', 1);
        })
        ->whereHas('category', function($query) {
            $query->where('status', 1);
        });
        
        $post = $post->where('slug', $slug)->where('post_type', 'post')->first();

        //dd($post->media->pluck('file_name')->toArray());'<img src="assets/posts/' . $media . '" alt="
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

        if(!empty($post) && auth('web')->check()  && $post->user_id == auth('web')->user()->id) {
            return view('frontend.post-show', ['post' => $post, 'description' => $description]);
        }elseif(!empty($post) && $post->status ==1 ) {
            return view('frontend.post-show', ['post' => $post, 'description' => $description]);
        }else {
            return redirect()->route('notFound');
        }
                        
    }

    public function commentStore(Request $request, $slug){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:5',
            'email' => 'required|email',
            'comment_id' => 'nullable|numeric',
            'comment' => 'required|string',
        ]);
        
        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);            
        }
        
        $post = Post::whereSlug($slug)->whereStatus(1)->first();
        // dd($post->approvedComments->pluck('id')->toArray());   
        if($post != null) {

            
            $comment = Comment::make([
                'name'          => auth()->check() ? auth()->user()->name : $request->name,
                'ip_address'    => $request->ip(),
                'email'         => auth()->check() ? auth()->user()->email : $request->email,
                'comment_id'    => in_array($request->comment_id, $post->approvedComments->pluck('id')->toArray()) ? $request->comment_id : null,
                'post_id'       => $post->id,
                'user_id'       => auth()->check() ? auth()->user()->id : null,
                'comment'       => $request->comment,
            ]);
            $comment->save();

            $result =  [
                'user'       => auth()->check() && auth()->user()->id == $post->user->id? 1 : 0,
                'name'       => $comment->name,                
                'email'       => $comment->email,                
                'comment_id' => $comment->id,
                'comment'    => $comment->comment,
                'create_date'=> $comment->created_at->format('M j\, Y \a\t g\:i a')
            ];
            return response()->json($result);


            /*  return redirect()->route('post.show', ['slug'=>$slug])->with([
                'message'       => 'Comment added successfully',
                'alert-type'    => 'success'
            ]); */
            
        }else {
            return redirect()->route('home')->with([
                'message'       => 'Something was wrong',
                'alert-type'    => 'danger'
            ]);
        }
    }

    public function page($slug){
        $post = Post::where('slug',$slug)->where('post_type', 'page')->first();
        
        if($post) {
                    // عرض الصور ضمن البوست
                $descriptionArray = explode('[img][/img]', $post->description);        
                $description = $post->description;
                $index = 0;
                if(!empty($post->media)) {
                    foreach($post->media->pluck('file_name')->toArray() as $media) {
                        $descriptionArray[$index] = $descriptionArray[$index] . '<img src="'.asset('assets/pages/'. $media)  . '" alt="">';
                        $index++;
                    }
                    $description = implode('', $descriptionArray);
                }
            return view('frontend.page', ['post' => $post, 'description' => $description]);
        }else {
            return redirect()->route('home');
        }        
    } 

    public function contact(){
        return view('frontend.contact');
    } 

    public function sendContact(Request $request){

        
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|min:4',
            'email' => 'required|email',
            'title' => 'required|string|min:10',
            'message' => 'required|string|min:50'
        ]);
        if($validator->fails()) {
            return redirect()->route('contact')->withErrors($validator)->withInput();
        }
        $data['name']   = $request->input('name');
        $data['email']  = $request->input('email');
        $data['title']  = $request->input('title');
        $data['message'] = $request->input('message');
        $data['ip_address'] = $request->ip();

        $contact = Contact::create($data);
        
        if($contact) {
            try{
                Mail::to($data['email'])->send(new contactStored($contact));

                return redirect()->route('contact')->with([
                    'message'       => 'We recived your Email and we will replay as soon as posibale',
                    'alert-type'    => 'success'
                ]);
            }
            catch(Exception $e) {                

                return redirect()->route('contact')->with([
                    'message'       => 'We recived your Email and we will replay as soon as posibale',
                    'alert-type'    => 'success'
                ]);
            }
            

        }else {

            return redirect()->route('contact')->with([
                'message'       => 'Something was wrong, please retry later',
                'alert-type'    => 'danger'
            ]);
        }


       
    }
    
    public function categories() {
        $categories = Category::where('status', 1)->withCount('posts')->orderBy('posts_count', 'DESC')->get();
        return view('frontend.categories', ['allCategories' => $categories]);
    }

    public function categoryShow($name) {

        $posts = Post::with(['media', 'user'])->whereHas('user', function($query) {
                    $query->where('status', 1);
                })->whereHas('category', function($query) use($name) {
                    $query->where('status', 1)->where('name', $name);
                })
                ->where('status', 1)->where('post_type', 'post');

        $posts = $posts->orderBy('updated_at', 'DESC')->paginate(7);

        return view('frontend.index',['posts' => $posts, 'viewType' => 'category', 'categoryName'=>$name]);

    }


    public function archiveShow($year ,$month ) {
        $posts = Post::with(['category', 'media', 'user'])
            ->whereHas('category', function($query){
                $query->whereStatus(1);
            })
            ->whereHas('user', function($query){
                $query->whereStatus(1);
            })
            ->wherePostType('post')->whereStatus(1)        
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->orderBy('created_at', 'desc')->paginate(7);

        return view('frontend.index', ['posts' => $posts, 'viewType' => 'archive', 'year' => $year, 'month' => $month]);
    }    

    public function userPostsShow($username) {

        $posts = Post::with(['media', 'user'])->whereHas('category', function($query) {
            $query->where('status', 1);
        })->whereHas('user', function($query) use($username) {
            $query->where('status', 1)->where('username', $username);
        })
        ->where('status', 1)->where('post_type', 'post');

        $posts = $posts->orderBy('updated_at', 'DESC')->paginate(7);

        return view('frontend.index',['posts' => $posts, 'viewType' => 'user']);
    }

    public function notFound(){
        return view('frontend.404');
    }

}
