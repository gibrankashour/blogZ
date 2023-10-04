@extends('layouts.app')

@section('content')

<!-- Start Blog Area -->
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    
    <div class="container">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update Information</a></li>
            </ol>
        </nav>

        <div class="row">

            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                @include('frontend.partial.user-sidebar')
            </div>

            <div class="col-lg-9 col-12">
                
                <form action=" {{ route('dashboard.myInformation') }} " method="POST" enctype="multipart/form-data" class="white-shadow-form shadow-1 p-4">
                    @csrf
                    @method('put')
                    <h2 class="mb-3">{{ $user->name }}</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" value="{{old('name', $user->name)}}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> 
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" value="{{old('username', $user->username)}}" class="form-control @error('username') is-invalid @enderror" id="name" placeholder="">
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> 
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" name="mobile" value="{{old('mobile', $user->mobile)}}" class="form-control @error('mobile') is-invalid @enderror" id="mobile" placeholder="">
                        @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> 
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" value="{{old('email', $user->email)}}" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> 
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="receive_email">Receive email</label>
                                <select name="receive_email" class="form-control @error('receive_email') is-invalid @enderror" id="receive_email">
                                    <option value="1" @if(old('receive_email', $user->receive_email) === 1) selected @endif>Yes</option>
                                    <option value="0" @if(old('receive_email', $user->receive_email) === 0) selected @endif>No</option>
                                </select>
                                @error('receive_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> 
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="bio" class="form-label">Description</label>
                        <textarea name="bio"  class="form-control @error('bio') is-invalid @enderror" id="bio" rows="3">{{old('bio', $user->bio)}}</textarea>
                        @error('bio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> 
                        @enderror
                    </div>                    
                        
                    <div class="form-group user-photo">
                        <label for="user_image" class="form-label">Profile photo</label>
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <input name="user_image" id="user_image" type="file" class="form-control @error('user_image') is-invalid @enderror" >
                            </div>
                            <div class="col-md-2 @if(auth()->user()->user_image == null) d-none @endif">
                                <a href="{{route('dashboard.destroyUserImage', 'profile')}}" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                            </div>
                        </div>

                        @error('user_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> 
                        @enderror
                        <small id="username" class="form-text text-muted">It is very recommended to add photo with dimentions 300<small>X</small>373 </small>
                    </div>

                    <div class="form-group user-photo">
                        <label for="cover_image" class="form-label">Cover photo</label>
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <input name="cover_image" id="cover_image" type="file" class="form-control @error('cover_image') is-invalid @enderror" >
                            </div>
                            <div class="col-md-2 @if(auth()->user()->cover_image == null) d-none @endif">
                                <a href="{{route('dashboard.destroyUserImage', 'cover')}}" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                            </div>
                        </div>                        
                        @error('cover_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> 
                        @enderror
                        <small id="username" class="form-text text-muted">It is very recommended to add photo with dimentions 1920<small>X</small>1285 </small>
                    </div>


                    <button type="submit" class="btn btn-primary mb-2">Update Information</button>
                </form>                
                
                <form action="{{route('dashboard.updatePassword')}}" method="POST" enctype="multipart/form-data" class="white-shadow-form shadow-1 p-4 mt-3">
                    @method('put')
                    @csrf
                    <h4 class="mb-3">Update Password</h4>
                    <div class="row mb-3">								
                        <label for="current_password" class="form-label col-md-3">Current password</label>
                        <div class=" col-md-6">										
                            <input type="password" name="current_password"  class="form-control @error('current_password') is-invalid @enderror" id="current_password" placeholder="">
                            
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                            @enderror
                        </div>								
                    </div>
                    <div class="row mb-3">								
                        <label for="password" class="form-label col-md-3">New password</label>
                        <div class=" col-md-6">										
                            <input type="password" name="password"  class="form-control @error('password') is-invalid @enderror" id="password" placeholder="">
                            
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                            @enderror
                        </div>								
                    </div>
                    <div class="row mb-3">								
                        <label for="password_confirmation" class="form-label col-md-3">Re Password</label>
                        <div class=" col-md-6">										
                            <input type="password" name="password_confirmation"  class="form-control" id="password_confirmation" placeholder="">
                        </div>								
                    </div>
    
                    <button type="submit" class="btn btn-warning mb-2">Update Password</button>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Blog Area -->

@endsection