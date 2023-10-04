@extends('layouts.admin')


@section('content')

<h1 class="h3 mb-2 text-gray-800">Roles</h1>
<p class="mb-4 mt-4"> You can add new role from here
    <a href="{{ route('admin.role.create') }}" class="btn btn-info btn-icon-split" target="_blank">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Add Role</span>
    </a>
</p>

<div class="card shadow mb-4">    
    <div class="card-header p-0">
        <div class="card shadow mb-3 card-search">
            <!-- Card Header - Accordion -->
            <a href="#collapseCardExample" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Roles</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardExample">
                <div class="card-body">
                    @include('backend.roles.filter')
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
                                <a href="{{route('admin.role.all',['sort_by'=>'name', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.role.all',['sort_by'=>'name', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Guard name</span>
                            <div class="arrows">
                                <a href="{{route('admin.role.all',['sort_by'=>'guard_name', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'guard_name' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.role.all',['sort_by'=>'guard_name', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'guard_name' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Description</span>
                            <div class="arrows">
                                <a href="{{route('admin.role.all',['sort_by'=>'description', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'description' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.role.all',['sort_by'=>'description', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'description' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>                        
                        <th>
                            <span>Deletable</span>
                            <div class="arrows">
                                <a href="{{route('admin.role.all',['sort_by'=>'deletable', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'deletable' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.role.all',['sort_by'=>'deletable', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'deletable' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Created at</span>
                            <div class="arrows">
                                <a href="{{route('admin.role.all',['sort_by'=>'created_at', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.role.all',['sort_by'=>'created_at', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'desc' OR empty(request()->input('sort_by'))) active @endif">↓</a>
                            </div>
                        </th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>                        
                        <th>
                            <span>Name</span>
                            <div class="arrows">
                                <a href="{{route('admin.role.all',['sort_by'=>'name', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.role.all',['sort_by'=>'name', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'name' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Guard name</span>
                            <div class="arrows">
                                <a href="{{route('admin.role.all',['sort_by'=>'guard_name', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'guard_name' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.role.all',['sort_by'=>'guard_name', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'guard_name' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Description</span>
                            <div class="arrows">
                                <a href="{{route('admin.role.all',['sort_by'=>'description', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'description' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.role.all',['sort_by'=>'description', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'description' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>                        
                        <th>
                            <span>Deletable</span>
                            <div class="arrows">
                                <a href="{{route('admin.role.all',['sort_by'=>'deletable', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'deletable' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.role.all',['sort_by'=>'deletable', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'deletable' && request()->input('order_by') == 'desc') active @endif">↓</a>
                            </div>
                        </th>
                        <th>
                            <span>Created at</span>
                            <div class="arrows">
                                <a href="{{route('admin.role.all',['sort_by'=>'created_at', 'order_by'=>'asc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'asc') active @endif">↑</a>
                                <a href="{{route('admin.role.all',['sort_by'=>'created_at', 'order_by'=>'desc', 'limit_by' =>request()->input('limit_by')])}}" class="@if (request()->input('sort_by') == 'created_at' && request()->input('order_by') == 'desc' OR empty(request()->input('sort_by'))) active @endif">↓</a>
                            </div>
                        </th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                @forelse($roles as $role)
                    <tr>                        
                        
                        <td><a href="{{route('admin.role.show', $role->id)}}" target="_blank">{{ $role->name }}</a></td>
                        <td>{{ $role->guard_name }}</td>
                        <td>{{ $role->description }}</td>                        
                        <td>
                            @if ($role->deletable === 1)
                                <span class="text-success">Deletable</span>
                            @elseif($role->deletable === 0)
                                <span class="text-danger">Undeletable</span>
                            @endif
                        </td>
                        <td>{{ $role->created_at->format('d-m-Y h:i a') }}</td>
                        <td>                            
                            @if ($role->deletable === 1)
                            <div class="btn-group-flex">
                                <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-edit"></i>
                                    </span>      
                                    <span class="text">Edit</span>                              
                                </a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-icon-split" onclick="if (confirm('Are you sure to delete this role?') ) { document.getElementById('role-delete-{{ $role->id }}').submit(); } else { return false; }">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Delete</span>
                                </a>
                                <form action="{{ route('admin.role.destroy', $role->id) }}" method="post" id="role-delete-{{ $role->id }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                            @elseif($role->deletable === 0)
                                <span class="text-warning no-action">No actions can be taken</span>
                            @endif                                
                                
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center h2">No roles found</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
        <div class="row-">
            <div class="col-12">
                @if (!empty($roles))
                    <div class="float-right">
                        {!! $roles->appends(request()->input())->links('vendor.pagination.bootstrap-4') !!}
                    </div>         
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
