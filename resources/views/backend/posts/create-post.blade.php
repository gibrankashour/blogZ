@extends('layouts.admin')

@section('style')

<link rel="stylesheet" href="{{ asset('libraries/summernote/summernote-lite.css') }}">

@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Create post</h1>    
<nav aria-label="breadcrumb" class="my-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.post.all') }}">Posts</a></li>
        <li class="breadcrumb-item active" aria-current="page">create new post</li>
    </ol>
</nav>
    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h6 class="m-0 font-weight-bold text-primary">Create post</h6>            
        </div>
        <div class="card-body">
            <form action="{{route('admin.post.store')}}" method="post" class="admin-form" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title" class="form-label">Post Title</label>
                    <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="">
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span> 
                    @enderror
                </div>
                <div class="form-group">
                    <label for="summernote" class="form-label">Description</label>
                    <textarea name="description"  class="form-control @error('description') is-invalid @enderror" id="summernote" rows="3">{{old('description')}}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span> 
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                                <option value="1" @if(old('status') === 1) selected @endif>Active</option>
                                <option value="0" @if(old('status') === 0) selected @endif>Inactive</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" class="form-control @error('category') is-invalid @enderror" id="category">											
                                
                                @foreach($allCategories as $category)
                                    <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif> {{ $category->name }} </option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Comment-able">Comment Able</label>
                            <select name="Comment_able" class="form-control @error('Comment_able') is-invalid @enderror" id="Comment-able">
                                <option value="1" @if(old('comment-able') === 1) selected  @endif >Yes</option>
                                <option value="0" @if(old('comment-able') === 0) selected @endif >No</option>
                            </select>
                            @error('Comment_able')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group user-photo">
                    <label for="post_cover" class="form-label">Post cover</label>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="custom-file">
                                <input name="post_cover" id="post_cover" type="file" class="custom-file-input  @error('post_cover') is-invalid @enderror" >
                                <label for="post_cover" class="custom-file-label">Choose file...</label>
                                @error('post_cover')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> 
                                @enderror
                                <small  class="form-text text-muted">It is very recommended to add photo with dimentions <strong>1170<small>X</small>788</strong> & image size must be less than <strong>4MB</strong></strong></small>
                            </div>
                        </div>                            
                    </div>

                    
                </div>

                <div class="form-group @error('images.*') error-image @enderror">
                    <label for="" class="form-label">Post images</label>
                    <div class="row justify-content-center">
                        <div class="col-md-12 add-post-images">
                            <div class="custom-file mb-1">
                                <input name="images[]"  type="file" class="custom-file-input" id="post-image-1">
                                <label for="post-image-1" class="custom-file-label">Choose file...</label>
                            </div>                                                           
                            <div class="custom-file mb-1">
                                <input name="images[]"  type="file" class="custom-file-input" id="post-image-2">
                                <label for="post-image-2" class="custom-file-label">Choose file...</label>
                            </div>                                                           
                            <div class="custom-file mb-1">
                                <input name="images[]"  type="file" class="custom-file-input" id="post-image-4">
                                <label for="post-image-4" class="custom-file-label">Choose file...</label>
                            </div>                                                           
                        </div> 
                        @error('images.*')
                            <span class="col-md-12 invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> 
                        @enderror  
                        <div id="add-post-image">
                            <span class=""><i class="fa fa-plus"></i>Add another image</span>
                        </div>                           
                    </div>
                                          
                    <small  class="form-text text-muted">It is very recommended to add photo with dimentions <strong>1170<small>X</small>788</strong> & image size must be less than <strong>4MB</strong></small>
                </div>
                <div class=" pt-4">                    
                    <a href="#" class="btn btn-info btn-icon-split admin-btn">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Add New Post</span>
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

    <script src="{{ asset('libraries/summernote/summernote-lite.js') }}"></script>

    <script>
        $(function () {

            $('#summernote').summernote({
                placeholder: 'Write your post here',
                tabsize: 2,
                // height: 120,
                toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                // ['table', ['table']],
                // ['insert', ['link', 'picture', 'video']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
                ],
                minHeight: 200,             // set minimum height of editor
                // maxHeight: null,           // set maximum height of editor
                //focus: true
            });

        });

    </script>
@endsection