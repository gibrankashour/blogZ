@extends('layouts.admin')


@section('content')

<h1 class="h3 mb-2 text-gray-800">Comments</h1>


<div class="card shadow mb-4">    
    <div class="card-header p-0">
        <div class="card shadow mb-3 card-search">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Comments</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardExample">
                <div class="card-body">
                    @include('backend.comments.filter')
                </div>
            </div>
        </div>  

    </div>

    <div class="card-body">
        <div class="table-responsive">            
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>
                            <span>Name</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'author', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'author' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'author', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'author' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Comment</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'comment', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'comment' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'comment', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'comment' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Post title</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'posts_title', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'post_title' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'posts_title', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'post_title' && request()->input('order_by') == 'desc') active @endif">↓</a>
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
                        @if (canAnyPermissions(['edit category', 'delete category']))                            
                            <th class="text-center" style="width: 30px;">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>
                            <span>Name</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'author', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'author' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'author', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'author' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Comment</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'comment', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'comment' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'comment', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'comment' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Post title</span>
                            <div class="arrows">
                                <a href="{{route('admin.post.all',['sort_by'=>'post_title', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'post_title' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.post.all',['sort_by'=>'post_title', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'post_title' && request()->input('order_by') == 'desc') active @endif">↓</a>
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
                        @if (canAnyPermissions(['edit comment', 'delete comment']))                            
                            <th class="text-center" style="width: 30px;">Actions</th>
                        @endif
                    </tr>
                </tfoot>
                <tbody>
                @forelse($allComments as $comment)
                    <tr>
                        <td>{{ $comment->author }}</td>
                        <td><a href="{{route('admin.post.show', ['slug' => $comment->post->slug, 'comment' => $comment->id]) . '#' . $comment->id}}" target="_blank">{{ $comment->comment }}</a></td>
                        <td><a href="{{route('admin.post.show', $comment->post->slug)}}" target="_blank">{{ $comment->post->title }}</a></td>
                        <td>
                            @if ($comment->status() == 'Approved')
                                <span class="text-success">{{$comment->status()}}</span>
                            @elseif($comment->status() == 'Disapproved')
                                <span class="text-danger">{{$comment->status()}}</span>
                            @endif
                        </td>
                        <td>{{ $comment->created_at->format('d-m-Y h:i a') }}</td>
                        @if (canAnyPermissions(['activate comment', 'delete comment']))
                            <td>
                                <div class="btn-group-post">
                                    @can('activate comment')
                                        @if($comment->status == 1)
                                            <a href="{{ route('admin.comment.status', [$comment->id, 'disapprove']) }}" class="btn btn-warning btn-icon-split mb-1">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-times"></i>
                                                </span>      
                                                <span class="text">Disapprove</span>                              
                                            </a>
                                        @else
                                            <a href="{{ route('admin.comment.status', [$comment->id, 'approve']) }}" class="btn btn-secondary btn-icon-split mb-1">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>      
                                                <span class="text">Approve</span>                              
                                            </a>
                                        @endif
                                    @endcan
                                    @can('delete comment')
                                        <a href="javascript:void(0)" class="btn btn-danger btn-icon-split" onclick="if (confirm('Are you sure to delete this comment?') ) { document.getElementById('comment-delete-{{ $comment->id }}').submit(); } else { return false; }">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="text">Delete</span>
                                        </a>
                                        <form action="{{ route('admin.comment.destroy', $comment->id) }}" method="post" id="comment-delete-{{ $comment->id }}" style="display: none;">
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
                        <td colspan="6" class="text-center h2">No categories found</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
        <div class="row-">
            <div class="col-12">
                @if (!empty($allComments))
                    <div class="float-right">
                        {!! $allComments->appends(request()->input())->links('vendor.pagination.bootstrap-4') !!}
                    </div>         
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
