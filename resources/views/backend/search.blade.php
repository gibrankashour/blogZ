@extends('layouts.admin')
@section('content')


<h1 class="h3 mb-2 text-gray-800">Search results for : {{request()->input('search')}}</h1>
<nav aria-label="breadcrumb" class="my-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">search</li>
    </ol>
</nav>

@if($posts->count() > 0)
    <div class="admin-search">
        <h2>Posts</h2>
        @foreach($posts as $post)
            <div class="row mb-1">
                <div class="col-md-3 ">
                    @if($post->post_cover != null)
                        <img src="{{asset('assets/posts/' . $post->post_cover)}}" alt="{{$post->title}}" class="fit fit-150">
                        @else 
                        <img src="{{asset('assets/default/post.jpg')}}" alt="{{$post->title}}" class="fit fit-150">
                    @endif
                </div>
                <div class="col-md-9">
                    <h5>Post auther: {{$post->user->name}}</h5>
                    <p>{!! Illuminate\Support\Str::limit(str_replace('[img][/img]','',$post->description), 250) !!}</p>
                    <a href="{{ route('admin.post.show', $post->slug) }}" target="_blank">read more</a>
                </div>
            </div>
        @endforeach
        <a class="show-more-results btn btn-info" href="{{ route('admin.post.all', ['keyword' => request()->input('search')]) }}" target="_blank">Show more results</a>
    </div>
@endif

@if($users->count() > 0)
    <div class="admin-search">
        <h2>Users</h2>
        <div class="row mb-1">
            @foreach($users as $user)
                <div class="col col-md-4 ">
                    <div class="row">
                        <div class=" col-md-4 ">
                            @if($user->user_image != null)
                                <img src="{{asset('assets/users/' . $user->user_image)}}" alt="{{$user->username}}" class="fit fit-75">
                                @else 
                                <img src="{{asset('assets/default/user.jpg')}}" alt="{{$user->username}}" class="fit fit-75">
                            @endif
                        </div>
                        <div class=" col-md-8">
                            <h5>{{$user->name}}</h5>
                            <p>Post counts {{$user->posts_count}}</p>
                            <a href="{{ route('admin.user.edit', $user->username) }}" target="_blank">Edit user</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="show-more-results btn btn-info" href="{{ route('admin.user.all', ['keyword' => request()->input('search')]) }}" target="_blank">Show more results</a>
    </div>
@endif

@if($comments->count() > 0)
    <div class="admin-search">
        <h2>Comments</h2>
        <div class="row mb-1">
            @foreach($comments as $comment)
                <div class=" col-md-6">
                    <div class="row comment-container">
                        <div class=" col-md-3 ">
                            @if($comment->user_id != null && $comment->user->user_image != null)
                                <img src="{{asset('assets/users/' . $comment->user->user_image)}}" alt="{{$comment->user->username}}" class="fit fit-75">
                                @else 
                                <img src="{{asset('assets/default/comment.jpeg')}}" alt="{{$comment->name}}" class="fit fit-75">
                            @endif
                        </div>
                        <div class=" col-md-9">
                            <h5>Commenter: 
                                @if($comment->user_id != null)
                                    {{$comment->user->name}}
                                @else
                                    {{$comment->name}}
                                @endif    
                            </h5>
                            <a href="{{ route('admin.post.show', $comment->post->slug) }}" target="_blank">{{$comment->post->title}}</a>
                            <p>{!! Illuminate\Support\Str::limit($comment->comment, 150) !!}</p>
                            <a href="{{ route('admin.post.show', ['slug' => $comment->post->slug, 'comment' => $comment->id]) . '#' .$comment->id}}" target="_blank">read more</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="show-more-results btn btn-info" href="{{ route('admin.comment.all', ['keyword' => request()->input('search')]) }}" target="_blank">Show more results</a>
    </div>
@endif
@endsection
