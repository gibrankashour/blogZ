@extends('layouts.admin')
@section('content')

@if(!empty($errors))

@endif
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Show role</h6>
            @if ($role->deletable === 1)
            <div class="btn-group-flex">
                <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-edit"></i>
                    </span>      
                    <span class="text">Edit</span>                              
                </a>
                <a href="javascript:void(0)" class="btn btn-danger btn-icon-split" onclick="if (confirm('Are you sure to delete this role?') ) { document.getElementById('role-delete-{{ $role->id }}').submit(); } else { return false; }">
                    <span class="icon text-white-50">
                        <i class="fas fa-trash"></i>
                    </span>
                    <span class="text">Delete</span>
                </a>
                <form action="{{ route('admin.role.destroy', $role->id) }}" method="post" id="role-delete-{{ $role->id }}" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
            @elseif($role->deletable === 0)
                <span class="text-warning no-action">No actions can be taken</span>
            @endif             
        </div>
        <div class="create-role">
            <div class="permission">
                <h3 class="text-center mt-3 text-uppercase">{{$role->name}}</h3>
            </div>  
            <div class="permissions">
                @foreach ($sections as $section)
                    <div class="permission">                                    
                        <h6 class="text-uppercase">{{$section->section}}</h6>
                        <div class="row pl-4 pt-2">
                            @foreach($permissions as $permission)
                                @if($permission->section == $section->section)
                                    <div class="col-md-3">
                                        <div class="show-permission">
                                            @if(in_array($permission->name, $permissionsName))
                                                <i class="fa fa-check text-success mr-1" aria-hidden="true"></i>
                                                <span class="text-success" >{{$permission->name}}</span>
                                                @else
                                                <i class="fa fa-times mr-1" aria-hidden="true"></i>
                                                <span class="" >{{$permission->name}}</span>
                                            @endif                                                
                                        </div>
                                    </div>                                       
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach                    
            </div>                
        </div>
    </div>

@endsection