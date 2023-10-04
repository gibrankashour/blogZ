@extends('layouts.app')

@section('style')

<!-- Start Bootstrap-fileinput -->
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" crossorigin="anonymous"> --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous"/> --}}
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" crossorigin="anonymous"/>

<link href="{{ asset('libraries/kartik-v-bootstrap-fileinput/fileinput.css') }}" media="all" rel="stylesheet" type="text/css" />
<link href="{{ asset('libraries/kartik-v-bootstrap-fileinput/fileinput-rtl.css') }}" media="all" rel="stylesheet" type="text/css" />
<link href="{{ asset('libraries/kartik-v-bootstrap-fileinput/themes/explorer-fas/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<!-- End Bootstrap-fileinput -->
<link rel="stylesheet" href="{{ asset('libraries/summernote/summernote-lite.css') }}">

@endsection

@section('content')
{{-- {{dd(request()->search)}} --}}
<!-- Start Blog Area -->
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.allPosts') }}">All posts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create post</a></li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                @include('frontend.partial.user-sidebar')
            </div>

            <div class="col-lg-9 col-12">
                
                
                <form action=" {{ route('dashboard.storePost') }} " method="POST" enctype="multipart/form-data" class="white-shadow-form shadow-1 p-4">
                    @csrf
                    <h2 class="mb-3">Create Post</h2>
                    {{-- {{dd($errors)}} --}}
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
                                <input name="post_cover" id="post_cover" type="file" class="form-control @error('post_cover') is-invalid @enderror" >
                            </div>                            
                        </div>

                        @error('post_cover')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> 
                        @enderror
                        <small  class="form-text text-muted">It is very recommended to add photo with dimentions <strong>1170<small>X</small>788</strong> & image size must be less than <strong>4MB</strong></strong></small>
                    </div>

                    <div class="form-group @error('images.*') error-image @enderror">
                        <label for="" class="form-label">Post images</label>
                        <div class="row justify-content-center">
                            <div class="col-md-12 add-post-images">
                                <input name="images[]"  type="file" class="form-control mb-1" >
                                <input name="images[]"  type="file" class="form-control mb-1" >
                                <input name="images[]"  type="file" class="form-control mb-1" >                                
                            </div> 
                            <div id="add-post-image">
                                <span class=""><i class="fa fa-plus"></i>Add another image</span>
                            </div>                           
                        </div>
                        @error('images.*')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> 
                        @enderror                        
                        <small  class="form-text text-muted">It is very recommended to add photo with dimentions <strong>1170<small>X</small>788</strong> & image size must be less than <strong>4MB</strong></small>
                    </div>

                    {{-- <div class="form-group">
                        <label for="input-id">Images</label>
                        <div class="file-loading">
                            <input name="images[]" id="input-id" type="file" multiple class="file @error('images') is-invalid @enderror"  data-theme="fas"  data-overwrite-initial="false" >
                        </div>
                        @error('images')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> 
                        @enderror
                    </div> --}}

                    <button type="submit" class="btn btn-primary mb-2">Create post</button>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Blog Area -->

@endsection

@section('script')
    
<!-- Start Bootstrap-fileinput -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script> --}}
{{-- <script src="{{ asset('libraries/kartik-v-bootstrap-fileinput/plugins/piexif.min.js') }}" type="text/javascript"></script> --}}
{{-- <script src="{{ asset('libraries/kartik-v-bootstrap-fileinput/plugins/sortable.min.js') }}" type="text/javascript"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> --}}
{{-- <script src="{{ asset('libraries/kartik-v-bootstrap-fileinput/fileinput.js') }}" type="text/javascript"></script> --}}
{{-- <script src="{{ asset('libraries/kartik-v-bootstrap-fileinput/themes/fas/theme.js') }}" ></script> --}}
{{-- <script src="{{ asset('libraries/kartik-v-bootstrap-fileinput/themes/explorer-fas/theme.js') }}" ></script> --}}

<!-- End Bootstrap-fileinput -->
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
<script>

    $('#input-id').fileinput({
            theme: 'fas',
            uploadUrl: '#', // إجباري لازم تحطا مشان يطلع زر الحذف عالصورة
            allowedFileExtensions: ['jpg', 'png', 'jpeg'],
            maxFileCount: 5,
            allowedFileTypes: ['image'],
            showCancel: true,
            showRemove: false,
            showUpload: false,
            overwriteInitial: false,
            fileActionSettings: { //الرموز يلي رح تطلع عالصورة 
                    showRemove: true,
                    showUpload: false,
                    showZoom: true,
                    showDrag: false,
            },
        });
</script>

@endsection