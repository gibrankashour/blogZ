@extends('layouts.admin')


@section('content')

<h1 class="h3 mb-2 text-gray-800">Users</h1>
@can('store user')
    <p class="mb-4 mt-4"> You can add new user from here
        <a href="{{ route('admin.user.create') }}" class="btn btn-info btn-icon-split" target="_blank">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Add User</span>
        </a>
    </p>
@endcan

<div class="card shadow mb-4">    
    <div class="card-header p-0">
        <div class="card shadow mb-3 card-search">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Users</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardExample">
                <div class="card-body">
                    @include('backend.users.filter')
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
                            <span>Image</span>
                        </th>
                        <th>
                            <span>Name</span>
                            <div class="arrows">
                                <a href="{{route('admin.user.all',['sort_by'=>'name', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.user.all',['sort_by'=>'name', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Username</span>
                            <div class="arrows">
                                <a href="{{route('admin.user.all',['sort_by'=>'username', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'username' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.user.all',['sort_by'=>'username', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'username' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Email</span>
                            <div class="arrows">
                                <a href="{{route('admin.user.all',['sort_by'=>'email', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'email' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.user.all',['sort_by'=>'email', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'email' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Posts count</span>
                            <div class="arrows">
                                <a href="{{route('admin.user.all',['sort_by'=>'posts_count', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'posts_count' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.user.all',['sort_by'=>'posts_count', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'posts_count' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Status</span>
                            <div class="arrows">
                                <a href="{{route('admin.user.all',['sort_by'=>'status', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.user.all',['sort_by'=>'status', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Created at</span>
                            <div class="arrows">
                                <a href="{{route('admin.user.all',['sort_by'=>'created_at', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.user.all',['sort_by'=>'created_at', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'desc' OR empty(request()->input('sort_by'))) active @endif">↓</a>
                            </div>
                        </th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>
                            <span>Image</span>
                        </th>
                        <th>
                            <span>Name</span>
                            <div class="arrows">
                                <a href="{{route('admin.user.all',['sort_by'=>'name', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.user.all',['sort_by'=>'name', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Username</span>
                            <div class="arrows">
                                <a href="{{route('admin.user.all',['sort_by'=>'username', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'username' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.user.all',['sort_by'=>'username', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'username' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Email</span>
                            <div class="arrows">
                                <a href="{{route('admin.user.all',['sort_by'=>'email', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'email' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.user.all',['sort_by'=>'email', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'email' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Posts count</span>
                            <div class="arrows">
                                <a href="{{route('admin.user.all',['sort_by'=>'posts_count', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'posts_count' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.user.all',['sort_by'=>'posts_count', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'posts_count' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Status</span>
                            <div class="arrows">
                                <a href="{{route('admin.user.all',['sort_by'=>'status', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.user.all',['sort_by'=>'status', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'status' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Created at</span>
                            <div class="arrows">
                                <a href="{{route('admin.user.all',['sort_by'=>'created_at', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.user.all',['sort_by'=>'created_at', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'desc' OR empty(request()->input('sort_by'))) active @endif">↓</a>
                            </div>
                        </th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                @forelse($allUsers as $user)
                    <tr>                        
                        <td>
                            @if ($user->user_image != null)
                                <img src="{{asset('assets/users/' . $user->user_image)}}" alt="{{$user->username}}">
                            @else
                                <img src="{{asset('assets/default/user-small.jpeg')}}" alt="{{$user->username}}">
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>@if($user->posts_count > 0) <a href="{{route('admin.post.all', ['user' => $user->id])}}" target="_blank">{{ $user->posts_count }}</a> @else{{ $user->posts_count }} @endif</td>
                        
                        <td>
                            @if ($user->status() == 'Active')
                                <span class="text-success">{{$user->status()}}</span>
                            @elseif($user->status() == 'Inactive')
                                <span class="text-danger">{{$user->status()}}</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group-flex">
                                @can('edit user')
                                    <a href="{{ route('admin.user.edit', $user->username) }}" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>      
                                        <span class="text">Edit</span>                              
                                    </a>
                                @endcan
                                @can('delete user')
                                    <a href="javascript:void(0)" class="btn btn-danger btn-icon-split" onclick="if (confirm('Are you sure to delete this user?') ) { document.getElementById('user-delete-{{ $user->id }}').submit(); } else { return false; }">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">Delete</span>
                                    </a>
                                    
                                    <form action="{{ route('admin.user.destroy', $user->username) }}" method="post" id="user-delete-{{ $user->id }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endcan
                                
                                
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center h2">No users found</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
        <div class="row-">
            <div class="col-12">
                @if (!empty($allUsers))
                    <div class="float-right">
                        {!! $allUsers->appends(request()->input())->links('vendor.pagination.bootstrap-4') !!}
                    </div>         
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
