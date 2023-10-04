@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Settings</h1>
<p class="mb-4 mt-4"> You can edit all your site settings from here</p>


<div class="row mb-4">
    <div class="col-3 sittengs">
      <div class="list-group shadow" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action @if(!empty($section) && $section == 'general' OR empty($section)) active @endif " id="list-general-list" data-toggle="list" href="#list-general" role="tab" aria-controls="general">General</a>
        <a class="list-group-item list-group-item-action @if(!empty($section) && $section == 'social') active @endif" id="list-social-list" data-toggle="list" href="#list-social" role="tab" aria-controls="social">Social accounts</a>
        <a class="list-group-item list-group-item-action @if(!empty($section) && $section == 'images') active @endif" id="list-images-list" data-toggle="list" href="#list-images" role="tab" aria-controls="social">Website images</a>
      </div>
    </div>
    <div class="col-9">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade @if(!empty($section) && $section == 'general' OR empty($section))  show active @endif" id="list-general" role="tabpanel" aria-labelledby="list-general-list">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <h3 class="text-center mb-3">General settings</h3>
                            <form action="{{route('admin.settings.update',  'general')}}" method="post" class="admin-form">
                                @csrf
                                @method('put')
                                <div class="row">
                                    @foreach ($generals as $general)                                    
                                        <div class="@if($general->type == 'textarea') col-md-12 @else col-md-6 @endif">
                                            <div class="form-group">
                                                <label class="mt-2">{{ $general->display_name }}<span>*</span></label>

                                                @if($general->type == 'text')
                                                    <input  type="text" class="form-control @error($general->key) is-invalid @enderror" name="{{ $general->key }}" value="{{ old($general->key, $general->value) }}" required >
                                                    <small class="form-text text-muted">{{$general->details}}</small>
                                                @elseif($general->type == 'textarea')
                                                    <textarea name="{{ $general->key }}" class="form-control @error($general->key) is-invalid @enderror" rows="4" required>{{ old($general->key, $general->value) }}</textarea>
                                                    <small class="form-text text-muted">{{$general->details}}</small>
                                                @elseif($general->type == 'email')

                                                    @if($general->multiple_values == 1)
                                                        <div class="multiple-values">
                                                            @if(!empty(old($general->key)))
                                                                
                                                                @foreach (old($general->key) as $item)
                                                                <div class="delete_input">                                                                
                                                                    <input type="email" name="{{ $general->key }}[]"  value="{{ $item }}" class="mb-1 form-control @error($general->key . '.' . $loop->index) is-invalid @enderror" >
                                                                    @if($loop->index != 0) <i class="fa fa-times "></i> @endif
                                                                    @error($general->key . '.' . $loop->index)
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                @endforeach
                                                            @else
                                                                @foreach (explode('|', $general->value) as $item)
                                                                    <div class="delete_input">
                                                                        <input type="email" name="{{ $general->key }}[]"  value="{{ $item }}" class=" mb-1 form-control @error($general->key) is-invalid @enderror" required>
                                                                        @if($loop->index != 0) <i class="fa fa-times "></i> @endif                                                                        
                                                                    </div>
                                                                @endforeach  
                                                            @endif
                                                                                                                      
                                                        </div>
                                                        <i class="fa fa-plus bg-gray-900 text-gray-100  add-setting" id="add-email-setting"></i>
                                                    @endif
                                                
                                                @elseif($general->type == 'number')

                                                    @if($general->multiple_values == 1)
                                                        <div class="">
                                                            @if(!empty(old($general->key)))
                                                                
                                                                @foreach (old($general->key) as $item)
                                                                <div class="delete_input">                                                                
                                                                    <input type="number" name="{{ $general->key }}[]"  value="{{ $item }}" class="mb-1 form-control @error($general->key . '.' . $loop->index) is-invalid @enderror" >
                                                                    @if($loop->index != 0) <i class="fa fa-times "></i> @endif    
                                                                    @error($general->key . '.' . $loop->index)
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                @endforeach
                                                            @else
                                                                @foreach (explode('|', $general->value) as $item)
                                                                <div class="delete_input">
                                                                    <input type="number" name="{{ $general->key }}[]"  value="{{ $item }}" class="mb-1 form-control @error($general->key) is-invalid @enderror" required>
                                                                    @if($loop->index != 0) <i class="fa fa-times "></i> @endif
                                                                </div>
                                                                @endforeach  
                                                            @endif                                                                                                                       
                                                        </div>
                                                        <i class="fa fa-plus bg-gray-900 text-gray-100 add-setting" id="add-number-setting"></i>
                                                    @endif

                                                @endif
                                                
                                                @error($general->key)
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class=" pt-4">                    
                                    <a href="#" class="btn btn-success btn-icon-split admin-btn">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-fw fa-wrench"></i>
                                        </span>
                                        <span class="text">Update general settings</span>
                                    </a>                    
                                </div>
                            </form>                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade @if(!empty($section) && $section == 'social')  show active @endif" id="list-social" role="tabpanel" aria-labelledby="list-social-list">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <h3 class="text-center mb-3">Social settings</h3>
                            <form action="{{route('admin.settings.update',  'social')}}" method="post" class="admin-form-social">
                                @csrf
                                @method('put')
                                <div class="row">
                                    @foreach ($socials as $social)                                    
                                        <div class=" col-md-12">
                                            <div class="form-group">
                                                <label class="mt-2">{{ $social->display_name }}<span>*</span></label>

                                                @if($social->type == 'text')
                                                    <input  type="text" class="form-control @error($social->key) is-invalid @enderror" name="{{ $social->key }}" value="{{ old($social->key, $social->value) }}"  >
                                                    <small class="form-text text-muted">{{$social->details}}</small>
                                                @elseif($social->type == 'url')
                                                    <input  type="url" class="form-control @error($social->key) is-invalid @enderror" name="{{ $social->key }}" value="{{ old($social->key, $social->value) }}"  >
                                                    <small class="form-text text-muted">{{$social->details}}</small>
                                                @endif
                                                
                                                @error($social->key)
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class=" pt-4">                    
                                    <a href="#" class="btn btn-warning btn-icon-split admin-btn-social">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-fw fa-wrench"></i>
                                        </span>
                                        <span class="text">Update social settings</span>
                                    </a>                    
                                </div>
                            </form>                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade @if(!empty($section) && $section == 'images')  show active @endif" id="list-images" role="tabpanel" aria-labelledby="list-images-list">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <h3 class="text-center mb-3">Images settings</h3>    
                        <form action="{{route('admin.settings.update',  'images')}}" method="post" class="admin-form-images" enctype="multipart/form-data">
                            @csrf
                            @method('put')

                                @foreach ($images as $image)
                                <div class="row">                                        
                                    <div class="col-md-12">
                                        <label class="mt-2">{{ $image->display_name }}<span>*</span></label>
                                        <div class="custom-file">                                    
                                            <input type="file" name="{{ $image->key }}" id="{{ $image->key }}" class="custom-file-input @error($image->key) is-invalid @enderror">
                                            <label for="{{ $image->key }}" class="custom-file-label">Choose file...</label>
                                            @error($image->key)
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <small  class="form-text text-muted">{{$image->details}}</small>     
                                        </div>                                
                                    </div>
                                </div>
                                @endforeach                                
                            
                            <div class=" pt-4">                    
                                <a href="#" class="btn btn-info btn-icon-split admin-btn-images">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-fw fa-wrench"></i>
                                    </span>
                                    <span class="text">Update images settings</span>
                                </a>                    
                            </div>
                        </form>
                    </div>
                </div>
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