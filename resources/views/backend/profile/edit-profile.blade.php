@extends('layouts.admin')
@section('content')

<h1 class="h3 mb-2 text-gray-800">{{ auth()->user()->name}}</h1>
<nav aria-label="breadcrumb" class="my-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
    </ol>
</nav>
    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h6 class="m-0 font-weight-bold text-primary">{{ auth()->user()->name}}</h6>            
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">                    
                    @if (auth()->user()->user_image != null)
                        <div class="">
                            <img src="{{asset('assets/admins/' . auth()->user()->user_image)}}" alt="{{auth()->user()->username}}">
                            <a href="javascript:void(0)" class="btn btn-danger btn-icon-split my-3 mx-auto delete-user-image" onclick="if (confirm('Are you sure to delete this user?') ) { document.getElementById('form-delete-user-image').submit(); } else { return false; }">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
                                <span class="text">Delete image</span>
                            </a>  
                            <form action="{{route('admin.pofile.destroy.image')}}" method="post" class="d-none" id="form-delete-user-image">
                                @csrf
                                @method('delete')
                            </form>                            
                        </div>
                    @else
                        <img src="{{asset('assets/default/user.jpg')}}" alt="{{auth()->user()->username}}">
                    @endif
                </div>
                <div class="col-md-8">
                    <h3 class="text-center mb-3">Your information</h3>
                    <form action="{{route('admin.pofile.update')}}" method="post" class="admin-form" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span>*</span></label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', auth()->user()->name) }}" required  autofocus>
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
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', auth()->user()->username) }}" required  >
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
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', auth()->user()->email) }}" required>  
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
                                    <input id="mobile" type="number" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile', auth()->user()->mobile) }}" required  autofocus>
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
                                            <option value="1" @if(auth()->user()->status == 1) selected @endif>Active</option>                            
                                            <option value="0" @if(auth()->user()->status == 0) selected @endif>Inactive</option> 
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
                                            <option value="1" @if(auth()->user()->receive_email == 1) selected @endif>Yes</option>                            
                                            <option value="0" @if(auth()->user()->receive_email == 0) selected @endif>No</option> 
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
                                    <textarea name="bio" id="bio" class="form-control @error('bio') is-invalid @enderror" rows="5">{{ old('bio', auth()->user()->bio) }}</textarea>
                                    @error('bio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror  
                                </div>                                
                            </div>
                        </div>
                        <div class="row">
                            <label class="image-label">User Image</label>
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
                        
                        <div class=" py-4">                    
                            <a href="javascript:void(0)" class="btn btn-info btn-icon-split admin-btn">
                                <span class="icon text-white-50">
                                    <i class="fas fa-fw fa-wrench"></i>
                                </span>
                                <span class="text">Save Changes</span>
                            </a>                    
                        </div>
                    </form>


                    <hr class="m-3">
                    <h3 class="text-center mb-3">Update password</h3>
                    <form action="{{route('admin.pofile.update.password')}}" method="post" class="admin-form-password">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Old Password <span>*</span></label>                                    
                                    <input id="old-password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password"  required >
                                    
                                    @error('old_password')
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
                </div>
            </div>
        </div>
    </div>

@endsection