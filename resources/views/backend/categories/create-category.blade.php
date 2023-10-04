@extends('layouts.admin')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Create category</h1>    
<nav aria-label="breadcrumb" class="my-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.category.all') }}">Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">create new category</li>
    </ol>
</nav>
    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h6 class="m-0 font-weight-bold text-primary">Create category</h6>            
        </div>
        <div class="card-body">
            <form action="{{route('admin.category.store')}}" method="post" class="admin-form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label>Category name <span>*</span></label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required  autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-4">
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
                <div class="row">
                    <label class="image-label">Category Image</label>
                    <div class="col-12">
                        <div class="custom-file">                                    
                            <input type="file" name="image" id="image" class="custom-file-input @error('image') is-invalid @enderror">
                            <label for="image" class="custom-file-label">Choose file...</label>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small  class="form-text text-muted">It is very recommended to add photo with dimentions 600<small>X</small>338 </small>     
                        </div>                                
                    </div>
                </div>

                <div class=" pt-4">                    
                    <a href="#" class="btn btn-info btn-icon-split admin-btn">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Add New Category</span>
                    </a>                    
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('backend/vendor/bs-custom-file-input.js')}}"></script>
    <script>
    bsCustomFileInput.init()
    </script>
@endsection