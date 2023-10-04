@extends('layouts.app')

@section('content')
{{-- {{dd(request()->search)}} --}}
<!-- Start Blog Area -->
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">All posts</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                @include('frontend.partial.user-sidebar')
            </div>

            <div class="col-lg-9 col-12">
                <div class="dashboard-table">
                    @if( $posts->isNotEmpty() )
                    @if($status === '1')
                        <h3> All approved posts </h3>
                    @elseif($status === '0')
                        <h3> All pending posts </h3>
                    @else
                        <h3> All posts </h3>
                    @endif
                    <div class="table-responsive shadow-1">
                        <table class="table table-bordered m-0 table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Comments</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr>
                                    <td> <a href=" {{route('post.show', $post->slug)}} " >{{ $post->title }}</a> </td>
                                    <td> {{ $post->comments_count }} </td>
                                    <td> {{ $post->status }} </td>
                                    <td class="text-center">
                                        <a href="{{route('dashboard.editPost',$post->slug)}}" class="btn btn-success"><i class="fa fa-edit"></i></a> 
                                        <a href="{{route('dashboard.destroyPost',$post->slug)}}" class="btn btn-danger" onclick="event.preventDefault();if (confirm('Are you sure to delete this post?') ) { document.getElementById('post-delete-{{ $post->id }}').submit(); } else { return false; }">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="post-delete-{{ $post->id }}" action="{{route('dashboard.destroyPost',$post->slug)}}" method="POST" class="d-none">
                                            @csrf
                                            @method('delete')
                                        </form> 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$posts->links('vendor.pagination.boighor')}}
                        @else
                        <h2> There are no posts to show - <a href="" class="text-primary"> click here to write post! </a> </h2>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>
<!-- End Blog Area -->

@endsection