@extends('layouts.admin')
@section('content')

@if(!empty($errors))

@endif
    <div class="card shadow mb-4">
        <div class="card-header py-3 ">
            <h6 class="m-0 font-weight-bold text-primary">Create role</h6>            
        </div>
        <div class="create-role">
            
            <form action="{{route('admin.role.update', $role->id)}}" method="post" class="admin-form">
                @csrf
                @method('put')
                <div class="permission">
                    <h3 class="text-center mt-3">Role information</h3>
                    <div class="row">
                        <label class="col-md-2">Role name</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $role->name) }}" required  autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                
                <div class="permissions @error('permissions') errors @enderror @error('permissions.*') errors @enderror">
                    @foreach ($sections as $section)
                        <div class="permission">                                    
                            <h6 class="text-uppercase">{{$section->section}}</h6>
                            <div class="row pl-4 pt-2">
                                @foreach($permissions as $permission)
                                    @if($permission->section == $section->section)
                                        <div class="col-md-3">
                                            <div class="form-check form-check-inline">
                                                @if(!empty(session('updateFailed')) && session('updateFailed') == 'yes')
                                                    <input class="form-check-input" type="checkbox" name="{{str_replace(' ', '_',$permission->name)}}" id="{{$permission->id}}" value="yes" @if(!empty( old(str_replace(' ', '_',$permission->name)) )) checked  @endif>
                                                    @else
                                                    <input class="form-check-input" type="checkbox" name="{{str_replace(' ', '_',$permission->name)}}" id="{{$permission->id}}" value="yes" @if(in_array($permission->name, $permissionsName)) checked  @endif>
                                                @endif
                                                <label class="form-check-label" for="{{$permission->id}}">{{$permission->name}}</label>
                                            </div>
                                        </div>                                       
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @error('permissions')
                        <span class="text-danger p-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>    
                    @enderror
                    @error('permissions.*')
                        <span class="text-danger p-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>    
                    @enderror
                </div> 

                <div class="pt-3 pb-4 d-flex justify-content-center">                    
                    <a href="#" class="btn btn-info btn-icon-split admin-btn">
                        <span class="icon text-white-50">
                            <i class="fas fa-fw fa-wrench"></i>
                        </span>
                        <span class="text">Save Changes</span>
                    </a>                    
                </div>

            </form>
        </div>
    </div>

@endsection