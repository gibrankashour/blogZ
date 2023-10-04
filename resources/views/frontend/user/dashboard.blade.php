@extends('layouts.app')

@section('content')
{{-- {{dd(request()->search)}} --}}
<!-- Start Blog Area -->
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                @include('frontend.partial.user-sidebar')
            </div>

            <div class="col-lg-9 col-12">
                
                <div class="row justiy-content-center">
                    <div class="col-md-4">
                        <div class=" mx-auto card text-white bg-primary mb-3 text-center dashboard-card shadow-1" style="max-width: 18rem;">
                            <div class="card-header">
                                <h5 class="">Approved posts</h5>
                            </div>                            
                            <div class="card-body p-0">
                                <p class="card-text"><a href="{{route('dashboard.allPosts', ['status' => '1'])}}"> {{ auth()->user()->approvedPosts()->count() }} </a></p>
                            </div>
                        </div>                        
                    </div>
                    <div class="col-md-4">
                        <div class=" mx-auto card text-white bg-secondary mb-3 text-center dashboard-card shadow-1" style="max-width: 18rem;">
                            <div class="card-header">
                                <h5 class="">Pending posts</h5>
                            </div>                            
                            <div class="card-body p-0">
                                <p class="card-text"><a href="{{route('dashboard.allPosts', ['status' => '0'])}}"> {{ auth()->user()->pendingPosts()->count() }} </a></p>
                            </div>
                        </div>                        
                    </div>
                    <div class="col-md-4">
                        <div class=" mx-auto card text-white bg-success mb-3 text-center dashboard-card shadow-1" style="max-width: 18rem;">
                            <div class="card-header">
                                <h5 class="">All comments</h5>
                            </div>                            
                            <div class="card-body p-0">
                                <p class="card-text"><a href="{{route('dashboard.allComments')}}"> {{ $comments_count }} </a></p>
                            </div>
                        </div>                        
                    </div>
                    
                </div>
                
                <div class="dashboard-table">                    
                    @if( $posts->isNotEmpty() )
                    <h3 class="my-4"> Latest 10 posts </h3>
                    <div class="table-responsive shadow-1">
                        <table class="table table-bordered m-0  table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Comments</th>
                                    <th>Status</th>
                                    <th class="action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr>
                                    <td> <a href=" {{route('post.show', $post->slug)}} " >{{ $post->title }}</a> </td>
                                    <td> {{ $post->comments_count }} </td>
                                    <td> {{ $post->status }} </td>
                                    <td>
                                        <a href=" {{route('dashboard.editPost',$post->slug)}} " class="btn btn-success"><i class="fa fa-edit"></i></a> 
                                        <a href=" {{route('dashboard.destroyPost',$post->slug)}} " class="btn btn-danger" onclick="event.preventDefault();if (confirm('Are you sure to delete this post?') ) { document.getElementById('post-delete-{{ $post->id }}').submit(); } else { return false; }">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="post-delete-{{ $post->id }}" action=" {{route('dashboard.destroyPost',$post->slug)}} " method="POST" class="d-none">
                                            @csrf
                                            @method('delete')
                                        </form> 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                        @else
                        <h2> There are no posts to show - <a href="" class="text-primary"> click here to write post! </a> </h2>
                    @endif
                </div>

                <div class="dashboard-table">                    
                    @if( $comments->isNotEmpty() )
                    <h3 class="my-4"> Latest 10 Comments </h3>
                    <div class="table-responsive shadow-1">
                        <table class="table table-bordered m-0 table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Comment</th>
                                    <th>Post title</th>
                                    <th class="action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comments as $comment)
                                <tr>
                                    <td> 
                                        @if($comment->user_id != null)
                                            <a target="_blank" href="{{route('user.posts.show', $comment->user->username)}}">{{ $comment->user->name }}</a>
                                        @else
                                            {{ $comment->name }} 
                                        @endif                                        
                                    </td>
                                    <td> <a target="_blank" href="{{route('post.show',['slug' => $comment->post->slug, 'comment' => $comment->id] )}}#comment-{{$comment->id}}">{{ $comment->comment }} </td></a>
                                    <td> <a target="_blank" href="{{ route('post.show',$comment->post->slug) }}">{{ illuminate\support\str::limit($comment->post->description) }}</a> </td>
                                    <td class="text-center">
                                        @if ($comment->status == 1)
                                            <a href="{{route('dashboard.editComment', [$comment->id, 'disapprove', 'page' => request('page')])}}" class="btn btn-danger text-white px-2 py-1 " style="font-size: 12px;"><i class="fa fa-close mr-2"></i>Disapprove</a>
                                        @elseif ($comment->status == 0)
                                            <a href="{{route('dashboard.editComment', [$comment->id, 'approve', 'page' => request('page')])}}" class="btn btn-warning text-white px-2 py-1 " style="font-size: 12px;"><i class="fa fa-check mr-2"></i>Approve</a>
                                        @endif  
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>                            
                        </table>
                    </div>
                        @else
                        <h2> There are no comments to show </h2>
                    @endif
                </div>



            </div>

        </div>
    </div>
</div>
<!-- End Blog Area -->

@endsection