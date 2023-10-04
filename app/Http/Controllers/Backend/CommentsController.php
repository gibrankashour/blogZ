<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentsController extends Controller
{
    public function index() {

        $keyword    = request()->input('keyword') != null ? request()->input('keyword') : null;
        $status     = request()->input('status') != null && in_array(request()->input('status'),['1', '0']) ? request()->input('status') : 'all';
        $sort_by    = request()->input('sort_by') != null && in_array(request()->input('sort_by'),['author', 'comment', 'post_title', 'status', 'created_at']) ? request()->input('sort_by') : 'created_at';
        $order_by   = request()->input('order_by') != null && in_array(request()->input('order_by'),['asc', 'desc']) ? request()->input('order_by') : 'desc';
        $limit_by   = request()->input('limit_by') != null && in_array(request()->input('limit_by'),['10', '20', '50' ,'100']) ? request()->input('limit_by') : '20';

        $allComments = Comment::with(['user', 'post'])
            ->leftJoin('users','users.id','=','comments.user_id')//left join لانه من الممكن أن لا يكون صاحب التعليق مستخدم مسجل في الموقع 
            ->join('posts','posts.id','=','comments.post_id')
            // ->select('comments.*','posts.title as post_title','users.name as user_name', DB::raw('ifNull (users.name,comments.name) as author'));
            // ifNull() صحيحة في mysql ولكنها تنتج خطأ في postgsql
            ->select('comments.*','posts.title as post_title','users.name as user_name', DB::raw('COALESCE (users.name,comments.name) as author'));

        if($keyword != null) {
            $allComments = $allComments->search($keyword, null, true);
        }   
        if($status !== 'all') {
            $allComments = $allComments->where('comments.status', $status);
        }
        $allComments = $allComments->orderBy($sort_by, $order_by)->paginate($limit_by);

        return view('backend.comments.comments', ['allComments' => $allComments]);
    }

    public function status($id, $status) {
        $comment = Comment::where('id', $id)->first();
        
        if($comment) {
            if($status == 'disapprove') {
                $comment->update([
                    'status' => 0
                ]);
            }elseif($status == 'approve') {
                $comment->update([
                    'status' => 1
                ]);
            }else{
                return view('backend.404');
            }
            return redirect()->back()->with([
                'message' => 'Comment status changed successfully',
                'alert-type' => 'success'
            ]);
        }else {
            return view('backend.404');
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'comment_id' => 'nullable|numeric',
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|min:10',
        ],[
            'post_id.required' => 'Unknown post!',
            'post_id.exists' => 'Unknown post!',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();      
        }
        $post = Post::where('id', $request->input('post_id'))->where('post_type', 'post')->first();
        // dd($post->approvedComments->pluck('id')->toArray());   
        if($post != null) {
            $comment = Comment::make([
                'name'          => auth('admin')->user()->name,
                'ip_address'    => $request->ip(),
                'email'         => auth('admin')->user()->email,
                'comment_id'    => in_array($request->comment_id, $post->comments->pluck('id')->toArray()) ? $request->comment_id : null,
                'post_id'       => $post->id,
                'user_id'       => auth('admin')->user()->id,
                'comment'       => $request->comment,
            ]);
            $comment->save();
            return redirect()->back()->with([
                'message'       => 'Comment added successfully',
                'alert-type'    => 'success'
            ]);
        }else {
            return redirect()->route('admin.home')->with([
                'message'       => 'Something was wrong',
                'alert-type'    => 'danger'
            ]);
        }
    }

    public function destroy($id) {
        $comment = Comment::where('id', $id)->first();
        
        if($comment) {
            
            $comment->delete();
            return redirect()->back()->with([
                'message' => 'Comment deleted successfully',
                'alert-type' => 'success'
            ]);
        }else {
            return view('backend.404');
        }
    }

}
