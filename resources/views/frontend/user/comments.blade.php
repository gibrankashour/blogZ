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
                <div class="dashboard-table">
                    @if( $comments->isNotEmpty() )
                    <h3 class="">  All comments </h3>
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
                    {{$comments->links('vendor.pagination.boighor')}}
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