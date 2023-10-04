@extends('layouts.admin')
@section('content')

<div class="d-flex justify-content-between px-3">
    <h1 class="h3 mb-2 text-gray-800">Your information</h1>
    <div class="title-actions">
        <a href="{{ route('admin.profile.edit') }}" class="shadow-high btn btn-primary mr-2">Edit your information</a>
    </div>
</div>

<nav aria-label="breadcrumb" class="my-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">profile</li>
    </ol>
</nav>

<div> 
    <div class="card-header p-0 border-bottom-0">
        <div class="card shadow mb-3">
            <!-- Card Header - Accordion -->
            <a href="#basicInfoSection" class="d-block card-header py-3 " data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="basicInfoSection">
                <h6 class="m-0 font-weight-bold text-primary">Admin Information</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="basicInfoSection">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">                    
                            @if ($admin->user_image != null)
                                <img src="{{asset('assets/admins/' . $admin->user_image)}}" alt="{{$admin->username}}">
                            @else
                                <img src="{{asset('assets/default/admin.jpg')}}" alt="{{$admin->username}}">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3 class="text-center mb-3">{{ $admin->name }} information</h3>  
                            <div class="show-admin-info">
                                <div class="admin-info">
                                    <span>Name </span>
                                    <span>{{ $admin->name }}</span>
                                </div>
                                <div class="admin-info">
                                    <span>Username </span>
                                    <span>{{ $admin->username }}</span>
                                </div>
                                <div class="admin-info">
                                    <span>Email </span>
                                    <span>{{ $admin->email }}</span>
                                </div>
                                <div class="admin-info">
                                    <span>Mobile </span>
                                    <span>{{ $admin->mobile }}</span>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 admin-info">
                                        <span>Status </span>
                                        @if($admin->status == 1)
                                            <span class="text-success">Active</span>
                                        @else
                                            <span class="text-danger">Inactive</span>
                                        @endif                                        
                                    </div>
                                    <div class="col-md-6 admin-info">
                                        <span>Receive email </span>                                        
                                        @if($admin->receive_email == 1)
                                            <span class="text-success">Yes</span>
                                        @else
                                            <span class="text-danger">No</span>
                                        @endif   
                                    </div>
                                </div>    
                                <div class="admin-info">
                                    <span>Bio </span>
                                    @if(!empty($admin->bio))
                                        <p>{{ $admin->bio }}</p>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-header p-0 border-bottom-0">
        <div class="card shadow mb-3">
            <!-- Card Header - Accordion -->
            <a href="#rolesAndPermissions" class="d-block card-header py-3 " data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="rolesAndPermissions">
                <h6 class="m-0 font-weight-bold text-primary">Admin Information</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="rolesAndPermissions">
                <div class="card-body admin-roles-and-permissions">
                    <div class="row mx-1 align-items-center">
                        <div class="col-md-3">
                            Roles
                        </div>
                        <div class="col-md-9 r-p-container">
                            @forelse ($admin->roles as $role)
                                <span class="border-left-success">{{ $role->name }}</span>
                            @empty
                                <span class="border-left-danger">This admin does not have any roles</span>
                            @endforelse   
                        </div>
                    </div>                
                    <hr>
                    <div class="row mx-1 align-items-center">
                        <div class="col-md-3">
                            Inherited  Permissions
                        </div>
                        <div class="col-md-9 r-p-container">
                            @forelse ($admin->getPermissionsViaRoles() as $permission)
                                <span class="border-left-info">{{ $permission->name }}</span>
                            @empty
                                <span class="border-left-danger">This admin does not have any permissions inherited from roles</span>
                            @endforelse   
                        </div>
                    </div>
                    <div class="row mx-1 mt-2 align-items-center">
                        <div class="col-md-3">
                            Direct Permissions
                        </div>
                        <div class="col-md-9 r-p-container">
                            @forelse ($admin->getDirectPermissions() as $permission)
                                <span class="border-left-warning">{{ $permission->name }}</span>
                            @empty
                                <span class="border-left-danger">This admin does not have direct permissions</span>
                            @endforelse   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  

<form action="{{ route('admin.admin.destroy', $admin->username) }}" method="post" id="admin-delete" style="display: none;">
    @csrf
    @method('delete')
</form>

@endsection