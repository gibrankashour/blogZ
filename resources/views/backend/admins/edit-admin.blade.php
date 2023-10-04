@extends('layouts.admin')
@section('content')

<div class="d-flex justify-content-between px-3">
    <h1 class="h3 mb-2 text-gray-800">Edit Admin</h1>
    <div class="title-actions">
        <a href="{{ route('admin.admin.edit.password', $admin->username) }}" class="shadow-high btn btn-warning mr-2">Change Password</a>
        <a href="javascript:void(0)" class="shadow-high btn btn-danger" onclick="if (confirm('Are you sure to delete this Admin?') ) { document.getElementById('admin-delete').submit(); } else { return false; }">Delete Admin</a>
    </div>
</div>

<nav aria-label="breadcrumb" class="my-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.admin.all') }}">Admins</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $admin->name }}</li>
    </ol>
</nav>

<form action="{{route('admin.admin.update', $admin->username)}}" method="post" class="admin-form" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="card-header p-0 border-bottom-0">
        <div class="card shadow mb-3">
            <!-- Card Header - Accordion -->
            <a href="#basicInfoSection" class="d-block card-header py-3 " data-toggle="collapse"
                role="button" aria-expanded="false" aria-controls="basicInfoSection">
                <h6 class="m-0 font-weight-bold text-primary">Basic Information</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="basicInfoSection">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">                    
                            @if ($admin->user_image != null)
                                <div class="">
                                    <img src="{{asset('assets/admins/' . $admin->user_image)}}" alt="{{$admin->username}}">
                                    <a href="javascript:void(0)" class="btn btn-danger btn-icon-split my-3 mx-auto delete-user-image" onclick="if (confirm('Are you sure to delete this admin?') ) { document.getElementById('form-delete-admin-image').submit(); } else { return false; }">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">Delete image</span>
                                    </a>  
                         
                                </div>
                            @else
                                <img src="{{asset('assets/default/admin.jpg')}}" alt="{{$admin->username}}">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3 class="text-center mb-3">Admin information</h3>  
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name <span>*</span></label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $admin->name) }}" required  autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username <span>*</span></label>
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', $admin->username) }}" required  >
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small id="username" class="form-text text-muted">This username must be uniqe, and is used to make your profile link, if you let this field empty username will generated automatically </small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email <span>*</span></label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $admin->email) }}" required>  
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>mobile <span>*</span></label>
                                        <input id="mobile" type="number" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile', $admin->mobile) }}" required  autofocus>
                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                            @if (!empty( old('status') ))
                                            <option value="1" @if(old('status') == 1) selected @endif>Active</option>                            
                                            <option value="0" @if(old('status') == 0) selected @endif>Inactive</option>                                            
                                            @else
                                                <option value="1" @if($admin->status == 1) selected @endif>Active</option>                            
                                                <option value="0" @if($admin->status == 0) selected @endif>Inactive</option> 
                                            @endif                            
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror  
                                    </div>                                                      
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="receive_email">Receive email</label>
                                        <select name="receive_email" id="receive_email" class="form-control @error('receive_email') is-invalid @enderror">
                                            @if (!empty( old('receive_email') ))
                                                <option value="1" @if(old('receive_email') == 1) selected @endif>Yes</option>                            
                                                <option value="0" @if(old('receive_email') == 0) selected @endif>No</option>                                            
                                            @else
                                                <option value="1" @if($admin->receive_email == 1) selected @endif>Yes</option>                            
                                                <option value="0" @if($admin->receive_email == 0) selected @endif>No</option> 
                                            @endif                            
                                        </select>
                                        @error('admin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror     
                                    </div>                                                        
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="bio">Bio</label>
                                        <textarea name="bio" id="bio" class="form-control @error('bio') is-invalid @enderror" rows="5">{{ old('bio', $admin->bio) }}</textarea>
                                        @error('bio')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror  
                                    </div>                                
                                </div>
                            </div>
                            <div class="row">
                                <label class="image-label">Admin Image</label>
                                <div class="col-12">
                                    <div class="custom-file">                                    
                                        <input type="file" name="image" id="image" class="custom-file-input @error('image') is-invalid @enderror">
                                        <label for="image" class="custom-file-label">Choose file...</span></label>
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <small id="image" class="form-text text-muted">It is very recommended to add photo with dimentions 300<small>X</small>373 </small>     
                                    </div>                                
                                </div>
                            </div>
                            

                            {{--
                                <h3 class="text-center mb-3">Update password</h3>
                                <form action="{{route('admin.admin.update.password', $admin->username)}}" method="post" class="admin-form-password">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>New Password <span>*</span></label>                                    
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  required >
                                                
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Confirm Password <span>*</span></label>
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  required  >
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" py-4">                    
                                        <a href="javascript:void(0)" class="btn btn-warning btn-icon-split admin-btn-password">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </span>
                                            <span class="text">Update password</span>
                                        </a>                    
                                    </div>
                                </form>
                            --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-header p-0 border-bottom-0">
        <div class="card shadow mb-3">
            <!-- Card Header - Accordion -->
            <a href="#rolesSection" class="d-block card-header py-3  @if(!($errors->has('roles.*') OR $errors->has('roles'))) collapsed  @endif" data-toggle="collapse"
                role="button" aria-expanded="@if($errors->has('roles.*') OR $errors->has('roles')) true @else false  @endif" aria-controls="rolesSection">
                <h6 class="m-0 font-weight-bold text-primary">Roles</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="@if(!($errors->has('roles.*') OR $errors->has('roles'))) collapse @else errors @endif" id="rolesSection">
                <div class="card-body p-0">
                    @if (!empty(old('roles')))
                        <div class="shadow-rounded-role">
                            <h3 class="text-center mb-0 pt-3 pb-4 bg-white">unDeletable Roles</h3>
                            <div class="row justify-content-center py-2 px-4 bg-white ">
                                @foreach ($unDeletableRoles as $role)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="roles[]" id="{{'role-' . $role->id}}" value="{{str_replace(' ', '_',$role->name)}}" @if(in_array($role->name, old('roles'))) checked @endif>
                                            <label class="form-check-label" for="{{'role-' . $role->id}}">{{$role->name}}</label>
                                        </div>
                                    </div> 
                                @endforeach 
                            </div>
                        </div>
                        @if($deletableRoles->count() != 0)                        
                        <div class="shadow-rounded-role">                    
                            <h3 class="text-center my-0 pt-3 pb-4 bg-white">deletable Roles</h3>
                            <div class="row justify-content-center py-2 px-4 bg-white ">
                                @foreach ($deletableRoles as $role)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="roles[]" id="{{'role-' . $role->id}}" value="{{str_replace(' ', '_',$role->name)}}" @if(in_array($role->name, old('roles'))) checked @endif>
                                            <label class="form-check-label" for="{{'role-' . $role->id}}">{{$role->name}}</label>
                                        </div>
                                    </div> 
                                @endforeach 
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="shadow-rounded-role">
                            <h3 class="text-center mb-0 pt-3 pb-4 bg-white">unDeletable Roles</h3>
                            <div class="row justify-content-center py-2 px-4 bg-white ">
                                @foreach ($unDeletableRoles as $role)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="roles[]" id="{{'role-' . $role->id}}" value="{{str_replace(' ', '_',$role->name)}}" @if(in_array($role->name, $adminRoles)) checked @endif>
                                            <label class="form-check-label" for="{{'role-' . $role->id}}">{{$role->name}}</label>
                                        </div>
                                    </div> 
                                @endforeach 
                            </div>
                        </div>
                        @if($deletableRoles->count() != 0)                        
                        <div class="shadow-rounded-role">                    
                            <h3 class="text-center my-0 pt-3 pb-4 bg-white">deletable Roles</h3>
                            <div class="row justify-content-center py-2 px-4 bg-white ">
                                @foreach ($deletableRoles as $role)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="roles[]" id="{{'role-' . $role->id}}" value="{{str_replace(' ', '_',$role->name)}}" @if(in_array($role->name, $adminRoles)) checked @endif>
                                            <label class="form-check-label" for="{{'role-' . $role->id}}">{{$role->name}}</label>
                                        </div>
                                    </div> 
                                @endforeach 
                            </div>
                        </div>
                        @endif         
                    @endif

                    @error('roles')
                        <span class="text-danger p-2 d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>    
                    @enderror
                    @error('roles.*')
                        <span class="text-danger p-2 d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>    
                    @enderror

                </div>
            </div>
        </div>
    </div>

    <div class="card-header p-0 border-bottom-0">
        <div class="card shadow mb-3">
            <!-- Card Header - Accordion -->
            <a href="#permissionsSection" class="d-block card-header py-3 @if(!($errors->has('permissions.*') OR $errors->has('permissions'))) collapsed  @endif" data-toggle="collapse"
                role="button" aria-expanded="@if($errors->has('permissions.*') OR $errors->has('permissions')) true @else false @endif" aria-controls="permissionsSection">
                <h6 class="m-0 font-weight-bold text-primary">Direct Permissions</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="@if(!($errors->has('permissions.*') OR $errors->has('permissions'))) collapse @endif" id="permissionsSection">
                <div class="card-body create-role p-0">
                    <div class="permissions p-0 @error('permissions') errors @enderror @error('permissions.*') errors @enderror">
                        
                        @if (!empty(old('permissions')))

                            @foreach ($sections as $section)
                                <div class="permission">  
                                    @if ($loop->index == 0)
                                        <h3 class="text-center mb-4">Direct Permissions</h3>
                                    @endif                                  
                                    <h6 class="text-uppercase">{{$section->section}}</h6>
                                    <div class="row pl-4 pt-2">
                                        @foreach($permissions as $permission)
                                            @if($permission->section == $section->section)
                                                <div class="col-md-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" id="{{'permission-' . $permission->id}}" value="{{str_replace(' ', '_',$permission->name)}}" @if(in_array($permission->name, old('permissions')))  checked @endif>
                                                        <label class="form-check-label" for="{{'permission-' . $permission->id}}">{{$permission->name}}</label>
                                                    </div>
                                                </div>                                       
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                        @else
                           
                            @foreach ($sections as $section)
                                <div class="permission">  
                                    @if ($loop->index == 0)
                                        <h3 class="text-center mb-4">Direct Permissions</h3>
                                    @endif                                  
                                    <h6 class="text-uppercase">{{$section->section}}</h6>
                                    <div class="row pl-4 pt-2">
                                        @foreach($permissions as $permission)
                                            @if($permission->section == $section->section)
                                                <div class="col-md-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" id="{{'permission-' . $permission->id}}" value="{{str_replace(' ', '_',$permission->name)}}" @if(in_array($permission->name, $directPermissions))  checked @endif>
                                                        <label class="form-check-label" for="{{'permission-' . $permission->id}}">{{$permission->name}}</label>
                                                    </div>
                                                </div>                                       
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                        @endif

                        
                        @error('permissions')
                            <span class="text-danger p-2 d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                        @error('permissions.*')
                            <span class="text-danger p-2 d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>    
                        @enderror
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <div class="pt-3 pb-4 d-flex justify-content-center">                    
        <a href="#" class="btn btn-info btn-icon-split admin-btn">
            <span class="icon text-white-50">
                <i class="fas fa-fw fa-wrench"></i>
            </span>
            <span class="text">Save changes</span>
        </a>                    
    </div>

</form>

<form action="{{route('admin.admin.destroy.image', $admin->username)}}" method="post" class="d-none" id="form-delete-admin-image">
    @csrf
    @method('delete')
</form>  

<form action="{{ route('admin.admin.destroy', $admin->username) }}" method="post" id="admin-delete" style="display: none;">
    @csrf
    @method('delete')
</form>

@endsection