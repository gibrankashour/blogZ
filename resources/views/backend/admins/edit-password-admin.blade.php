@extends('layouts.admin')
@section('content')

<div class="d-flex justify-content-between px-3">
    <h1 class="h3 mb-2 text-gray-800">Edit Password</h1>
</div>

<nav aria-label="breadcrumb" class="my-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.admin.all') }}">Admins</a></li>
        <li class="breadcrumb-item "><a href="{{ route('admin.admin.edit', $admin->username) }}">{{ $admin->name }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Password</li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3 ">
        <h6 class="m-0 font-weight-bold text-primary">Edit password</h6>            
    </div>
    <div class="card-body">

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
    </div>
</div>

@endsection