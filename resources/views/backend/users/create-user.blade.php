@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h6 class="m-0 font-weight-bold text-primary">Create user</h6>            
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">                    
                    <img src="{{asset('assets/default/user.jpg')}}" alt="user image">                    
                </div>
                <div class="col-md-8">
                    <h3 class="text-center mb-3">User information</h3>
                    <form action="{{route('admin.user.store')}}" method="post" class="admin-form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span>*</span></label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required  autofocus>
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
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required  >
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
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>  
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
                                    <input id="mobile" type="number" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required  autofocus>
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
                                        <option value="1" @if(old('status') === '1' OR old('status') == null) selected @endif>Active</option>                            
                                        <option value="0" @if(old('status') === '0') selected @endif>Inactive</option>                            
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
                                        <option value="1" @if(old('receive_email') === '1' OR old('receive_email') == null) selected @endif>Yes</option>                            
                                        <option value="0" @if(old('receive_email') === '0') selected @endif>No</option>                            
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
                                    <textarea name="bio" id="bio" class="form-control @error('bio') is-invalid @enderror" rows="5">{{ old('bio') }}</textarea>
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
                                    <label for="image" class="custom-file-label">Choose file...</label>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small  class="form-text text-muted">It is very recommended to add photo with dimentions 300<small>X</small>373 </small>     
                                </div>                                
                            </div>
                        </div>
                        
                        <hr class="my-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password <span>*</span></label>                                    
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

                        
                        <div class=" pt-4">                    
                            <a href="#" class="btn btn-info btn-icon-split admin-btn">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text">Add New User</span>
                            </a>                    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('backend/vendor/bs-custom-file-input.js')}}"></script>
    <script>
    bsCustomFileInput.init()
    </script>
@endsection