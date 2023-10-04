@extends('layouts.admin')



@section('content')
<h1 class="h3 mb-2 text-gray-800">Show post</h1>    
<nav aria-label="breadcrumb" class="my-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.post.all') }}">Posts</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$post->title}}</li>
    </ol>
</nav>
    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h6 class="m-0 font-weight-bold text-primary">Show post</h6>            
        </div>
        <div class="row justify-content-center">
            <div class="col col-md-8 text-center">
                <h2 class="my-4">{{$post->title}}</h2>
            </div>
        </div>
        <div class="row px-5 mt-4">
            <div class="col col-md-6">
                <p class="lead">
                    Author : <a href="{{route('admin.post.all', ['user' => $post->user->id])}}">{{$post->user->name}}</a>
                </p>
                <p class="lead">
                    Category : <a href="{{route('admin.post.all', ['category' => $post->category->id])}}">{{$post->category->name}}</a>
                </p>
            
            </div>
            <div class="col col-md-6">
                <p class="lead">
                    Status :
                    @if($post->status == 1)
                        <span class="text-success">Active</span>
                    @else
                        <span class="text-danger">Inactive</span>                
                    @endif
                </p>
                @if($notes == null)
                    <p class="lead"> This post is <strong class="text-success">Visible</strong></p>
                @else
                    <p class="lead"> This post is <strong class="text-danger">Invisible</strong></p>
                    <ul>
                    @foreach ($notes as $note)
                        <li>{{$note}}</li>
                    @endforeach
                    </ul>
                @endif
            </div>
        </div>
        
        <div class="px-5 pb-0 pt-5">
            <h5>Post content</h5>
            <img src="@if($post->post_cover != null) {{asset('assets/posts/'. $post->post_cover)}} @else {{asset('assets/default/post.jpg')}} @endif" alt="{{$post->title}}" class="fit fit-500 my-4">
            <div class="post_content">{!!$description!!}</div>
        </div>

        <hr>

        <div class="comments-container pb-3">

            <h5 class="px-5 pb-3">Add comment</h5>

            @can('store comment')
            <form action="{{route('admin.comment.store')}}" method="post" class="px-5">
                @csrf
                <input type="hidden" name="post_id" value="{{$post->id}}">
                <div class="form-group">
                    <textarea  name="comment" id="" cols="30" rows="3" placeholder="Add comment" class="form-control @if(old('comment_id') == null) @error('comment') is-invalid @enderror @endif"></textarea>
                    @if(old('comment_id') == null)
                        @error('comment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> 
                        @enderror
                        @error('post_id')
                            <span class="text-danger d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> 
                        @enderror
                    @endif
                </div>
                <input type="submit" value="Add comment" class="btn btn-primary mb-3">
            </form>
            @endcan

            <h5 class="px-5 pb-3">Post comments</h5>
            <ul>
                @forelse ($post->parentComments as $parentComment)
                    <li class="comment @if(request()->input('comment') != null && request()->input('comment') == $parentComment->id) checked-comment @endif" id="{{$parentComment->id}}" >
                        <div class="comment-options">
                            <span>
                                @if($parentComment->user_id == null)
                                    {{$parentComment->name}}
                                @else
                                    <a href="{{route('admin.post.all',['user' => $parentComment->user->id])}}">
                                        {{$parentComment->user->name}} 
                                        @if( $parentComment->user->isAdmin())
                                            <strong>(Admin)</strong> 
                                        @endif
                                    </a>
                                @endif 

                                @if($parentComment->user_id == $post->user->id)
                                    (Post Author)
                                @endif 
                            </span>

                            @if($parentComment->status == 0)
                                <span class="text-danger"><strong>Inactive</strong></span>
                                <div class="hidden-options">
                                    <a href="{{ route('admin.comment.status', [$parentComment->id, 'approve']) }}" class="btn btn-secondary  py-0 px-1">Approve</a>
                            @else
                                <span class="text-success"><strong>Active</strong></span>
                                <div class="hidden-options">
                                    <a href="{{ route('admin.comment.status', [$parentComment->id, 'disapprove']) }}" class="btn btn-warning  py-0 px-1">Disapprove</a>
                            @endif 
                            
                                    @can('delete comment')
                                        <a href="javascript:void(0)" class="btn btn-danger  py-0 px-1"
                                        onclick="if (confirm('Are you sure to delete this comment?') ) { document.getElementById('comment-delete-{{ $parentComment->id }}').submit(); } else { return false; }">
                                            Delete    
                                        </a>
                                        <form action="{{ route('admin.comment.destroy', $parentComment->id) }}" method="post" id="comment-delete-{{ $parentComment->id }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endcan
                                    
                                    @can('store comment')
                                        <a href="#replay" class="btn btn-info  py-0 px-1 add-replay" data-comment="{{$parentComment->id}}">replay</a>
                                    @endcan
                                </div> <!-- end hidden-options -->
                        </div>
                        <div class="comment-comment">
                            {{$parentComment->comment}}
                        </div>
                        <div class="add-replay-form  @if(old('comment_id') == $parentComment->id) show @endif">
                            @can('store comment')
                                <form action="{{route('admin.comment.store')}}" method="post" class="px-3">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <input type="hidden" name="comment_id" value="{{$parentComment->id}}" id="">
                                    <div class="form-group">
                                        <textarea  name="comment" cols="30" rows="3" placeholder="Add comment" class="form-control  @if(old('comment_id') == $parentComment->id) @error('comment') is-invalid @enderror @endif"></textarea>
                                        @if(old('comment_id') == $parentComment->id)
                                            @error('comment')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span> 
                                            @enderror
                                            @error('post_id')
                                                <span class="text-danger d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span> 
                                            @enderror
                                        @endif
                                    </div>
                                    <input type="submit" value="Add comment" class="btn btn-primary mb-3">
                                </form>
                                @endcan
                        </div>
                    </li>
                    @if($parentComment->replies->count() > 0)
                        @include('backend.posts.post-comments', ['comments' => $parentComment->adminReplies])
                    @endif
                    
                @empty
                    <li class="text-info "> <strong> post doesn't have any comments </strong></li>
                @endforelse
            </ul>
        </div>
    </div>

@endsection
