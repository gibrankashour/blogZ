@extends('layouts.admin')


@section('content')

<h1 class="h3 mb-2 text-gray-800">Categories</h1>
@can('store category')
    <p class="mb-4 mt-4"> You can add new category from here
        <a href="{{ route('admin.category.create') }}" class="btn btn-info btn-icon-split" target="_blank">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Add Category</span>
        </a>
    </p>
@endcan

<div class="card shadow mb-4">    
    <div class="card-header p-0">
        <div class="card shadow mb-3 card-search">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardExample">
                <div class="card-body">
                    @include('backend.categories.filter')
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
                                <a href="{{route('admin.category.all',['sort_by'=>'name', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.category.all',['sort_by'=>'name', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'desc' OR empty(request()->input('sort_by'))) active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Posts count</span>
                            <div class="arrows">
                                <a href="{{route('admin.category.all',['sort_by'=>'posts_count', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'posts_count' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.category.all',['sort_by'=>'posts_count', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'posts_count' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Status</span>
                            <div class="arrows">
                                <a href="{{route('admin.category.all',['sort_by'=>'status', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.category.all',['sort_by'=>'status', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Created at</span>
                            <div class="arrows">
                                <a href="{{route('admin.category.all',['sort_by'=>'created_at', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.category.all',['sort_by'=>'created_at', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'desc') active @endif">↓</a>
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
                                <a href="{{route('admin.category.all',['sort_by'=>'name', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.category.all',['sort_by'=>'name', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'desc' OR empty(request()->input('sort_by'))) active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Posts count</span>
                            <div class="arrows">
                                <a href="{{route('admin.category.all',['sort_by'=>'posts_count', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'posts_count' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.category.all',['sort_by'=>'posts_count', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'posts_count' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Status</span>
                            <div class="arrows">
                                <a href="{{route('admin.category.all',['sort_by'=>'status', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.category.all',['sort_by'=>'status', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Created at</span>
                            <div class="arrows">
                                <a href="{{route('admin.category.all',['sort_by'=>'created_at', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.category.all',['sort_by'=>'created_at', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        @if (canAnyPermissions(['edit category', 'delete category']))                            
                            <th class="text-center" style="width: 30px;">Actions</th>
                        @endif
                    </tr>
                </tfoot>
                <tbody>
                @forelse($allCategories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>@if($category->posts_count > 0) <a href="{{route('admin.post.all', ['category' => $category->id])}}" target="_blank">{{ $category->posts_count }}</a> @else{{ $category->posts_count }} @endif</td>
                        <td>
                            @if ($category->status() == 'Active')
                                <span class="text-success">{{$category->status()}}</span>
                            @elseif($category->status() == 'Inactive')
                                <span class="text-danger">{{$category->status()}}</span>
                            @endif
                        </td>
                        <td>{{ $category->created_at->format('d-m-Y h:i a') }}</td>
                        @if (canAnyPermissions(['edit category', 'delete category']))
                            <td>
                                <div class="btn-group-flex">
                                    @can('edit category')
                                        <a href="{{ route('admin.category.edit', $category->slug) }}" class="btn btn-primary btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-edit"></i>
                                            </span>      
                                            <span class="text">Edit</span>                              
                                        </a>
                                    @endcan
                                    @can('delete category')
                                        <a href="javascript:void(0)" class="btn btn-danger btn-icon-split" onclick="if (confirm('Are you sure to delete this category?') ) { document.getElementById('category-delete-{{ $category->id }}').submit(); } else { return false; }">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="text">Delete</span>
                                        </a>
                                        <form action="{{ route('admin.category.destroy', $category->slug) }}" method="post" id="category-delete-{{ $category->id }}" style="display: none;">
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
                        <td colspan="5" class="text-center h2">No categories found</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
        <div class="row-">
            <div class="col-12">
                @if (!empty($allCategories))
                    <div class="float-right">
                        {!! $allCategories->appends(request()->input())->links('vendor.pagination.bootstrap-4') !!}
                    </div>         
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
