@extends('layouts.admin')


@section('content')

<h1 class="h3 mb-2 text-gray-800">Admins</h1>

<nav aria-label="breadcrumb" class="my-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Admins</li>
    </ol>
</nav>

<p class="mb-4 mt-4"> You can add new admin from here
    <a href="{{ route('admin.admin.create') }}" class="btn btn-info btn-icon-split" target="_blank">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Add Admin</span>
    </a>
</p>

<div class="card shadow mb-4">    
    <div class="card-header p-0">
        <div class="card shadow mb-3 card-search">
            <!-- Card Header - Accordion  collapsed-->
            <a href="#collapseCardExample" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Admins</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse " id="collapseCardExample">
                <div class="card-body">
                    @include('backend.admins.filter')
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
                        </th>                        
                        <th>
                            <span>Username</span>
                        </th>                        
                        <th>
                            <span>Email</span>
                        </th>                        
                        <th>
                            <span>Roles count</span>
                        </th>
                        <th>
                            <span>Permissions count</span>
                        </th>
                        <th>
                            <span>Created at</span>
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
                        </th>                        
                        <th>
                            <span>Username</span>
                        </th>                        
                        <th>
                            <span>Email</span>
                        </th>                        
                        <th>
                            <span>Roles count</span>
                        </th>
                        <th>
                            <span>Permissions count</span>
                        </th>
                        <th>
                            <span>Created at</span>
                        </th>
                        <th class="text-center" style="width: 30px;">Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                @forelse($allAdmins as $user)
                    <tr>                        
                        <td>
                            @if ($user->user_image != null)
                                <img src="{{asset('assets/admins/' . $user->user_image)}}" alt="{{$user->username}}">
                            @else
                                <img src="{{asset('assets/default/user-small.jpeg')}}" alt="{{$user->username}}">
                            @endif
                        </td>
                        <td><a href="{{route('admin.admin.show', $user->username)}}">{{ $user->name }}</a></td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->count() }}</td>
                        <td>{{ $user->getAllPermissions()->count() }}</td>
                        <td>{{ $user->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <div class="btn-group-flex">
                                <a href="{{ route('admin.admin.edit', $user->username) }}" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-edit"></i>
                                    </span>      
                                    <span class="text">Edit</span>                              
                                </a>
                                @if(!($user->hasRole('super admin') && $superAdmins <2))
                                <a href="javascript:void(0)" class="btn btn-danger btn-icon-split" onclick="if (confirm('Are you sure to delete this user?') ) { document.getElementById('user-delete-{{ $user->id }}').submit(); } else { return false; }">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Delete</span>
                                </a>
                                
                                <form action="{{ route('admin.admin.destroy', $user->username) }}" method="post" id="user-delete-{{ $user->id }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center h2">No admins found</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
        <div class="row-">
            <div class="col-12">
                @if (!empty($allAdmins))
                    <div class="float-right">
                        {!! $allAdmins->appends(request()->input())->links('vendor.pagination.bootstrap-4') !!}
                    </div>         
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
