@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{ asset('libraries/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')

<h1 class="h3 mb-2 text-gray-800">Posts</h1>
@can('store post')
    <p class="mb-4 mt-4"> You can add new post from here
        <a href="{{ route('admin.post.create') }}" class="btn btn-info btn-icon-split" target="_blank">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Add Post</span>
        </a>
    </p>
@endcan

<div class="card shadow mb-4">    
    <div class="card-header p-0">
        <div class="card shadow mb-3 card-search">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Posts</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardExample">
                <div class="card-body">
                    @include('backend.posts.filter')
                </div>
            </div>
        </div>  

    </div>

    <div class="card-body">
        <div class="table-responsive">            
            <table class="table table-bordered table-hover admin-posts-table" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>
                            <span>Title</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'title', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'title' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'title', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'title' && request()->input('order_by') == 'desc' ) active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>User name</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'user', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'user' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'user', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'user' && request()->input('order_by') == 'desc' ) active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Category</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'category', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'category' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'category', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'category' && request()->input('order_by') == 'desc' ) active @endif">↓</a>
                            </div>
                        </th>
                        <th style="width: 250px;">
                            Description
                        </th>
                        <th>
                            <span>Coments count</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'comments_count', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'comments_count' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'comments_count', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'comments_count' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Status</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'status', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'status', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Created at</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'created_at', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'created_at', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'desc' OR empty(request()->input('sort_by'))) active @endif">↓</a>
                            </div>
                        </th>
                        @if (canAnyPermissions(['edit post', 'delete post']))                            
                            <th class="text-center">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>
                            <span>Title</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'title', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'title' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'title', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'title' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>User name</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'user', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'user' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'user', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'user' && request()->input('order_by') == 'desc' ) active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Category</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'category', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'category' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'category', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'category' && request()->input('order_by') == 'desc' ) active @endif">↓</a>
                            </div>
                        </th>
                        <th style="width: 250px;">
                            Description
                        </th>
                        <th>
                            <span>Coments count</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'comments_count', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'comments_count' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'comments_count', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'comments_count' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Status</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'status', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'status', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Created at</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'created_at', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'created_at', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'desc' OR empty(request()->input('sort_by'))) active @endif">↓</a>
                            </div>
                        </th>
                        @if (canAnyPermissions(['edit post', 'delete post']))                            
                            <th class="text-center">Actions</th>
                        @endif
                    </tr>
                </tfoot>
                <tbody>
                @forelse($allPosts as $post)
                    <tr>
                        <td><a href="{{route('admin.post.show', $post->slug)}}" target="_blank">{{ $post->title }}</a></td>
                        <td><a href="{{route('admin.post.all', ['user' => $post->user->id])}}" target="_blank">{{ $post->user->name }}</a></td>
                        <td><a href="{{route('admin.post.all', ['category' => $post->category->id])}}" target="_blank">{{ $post->category->name }}</a></td>
                        <td>{!! Illuminate\Support\Str::limit(str_replace('[img][/img]','',$post->description), 150) !!}</td>
                        <td>{{ $post->comments->count() }}</td>
                        {{-- <td>{{ $post->comments_count }}</td> --}}
                        <td>
                            @if ($post->status() == 'Active')
                                <span class="text-success">{{$post->status()}}</span>
                            @elseif($post->status() == 'Inactive')
                                <span class="text-danger">{{$post->status()}}</span>
                            @endif
                        </td>
                        <td>{{ $post->created_at->format('d-m-Y h:i a') }}</td>
                        @if (canAnyPermissions(['edit post', 'delete post']))
                            <td>
                                <div class="btn-group-post">
                                    @can('edit post')
                                        @if($post->user->isAdmin())
                                            <a href="{{ route('admin.post.edit', $post->slug) }}" class="btn btn-primary btn-icon-split mb-1">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>      
                                                <span class="text">Edit</span>                              
                                            </a>
                                        @endif
                                        @if($post->status == 1)
                                            <a href="{{ route('admin.post.status', [$post->slug, 'disapprove']) }}" class="btn btn-warning btn-icon-split mb-1">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-times"></i>
                                                </span>      
                                                <span class="text">Disapprove</span>                              
                                            </a>
                                        @else
                                            <a href="{{ route('admin.post.status', [$post->slug, 'approve']) }}" class="btn btn-secondary btn-icon-split mb-1">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>      
                                                <span class="text">Approve</span>                              
                                            </a>
                                        @endif    
                                    @endcan
                                    @can('delete post')
                                        <a href="javascript:void(0)" class="btn btn-danger btn-icon-split" onclick="if (confirm('Are you sure to delete this post?') ) { document.getElementById('post-delete-{{ $post->id }}').submit(); } else { return false; }">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="text">Delete</span>
                                        </a>
                                        <form action="{{ route('admin.post.destroy', $post->slug) }}" method="post" id="post-delete-{{ $post->id }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endcan                                
                                </div>
                            </td>   
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center h2">No posts found</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
        <div class="row-">
            <div class="col-12">
                @if (!empty($allPosts))
                    <div class="float-right">
                        {!! $allPosts->appends(request()->input())->links('vendor.pagination.bootstrap-4') !!}
                    </div>         
                @endif
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
    <script src="{{ asset('libraries/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#users-select2').select2();
            $('#categories-select2').select2();
        });
    </script>
@endsection
