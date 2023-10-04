
<form action="{{ route('admin.admin.all') }}" method="GET" class="admin-form ">

    <div class="form-group row mb-3 pb-3 px-3">
        <label for="keyword" class="col-md-2 col-form-label">Search Field</label>                
        <input type="text" name="keyword" value="{{request()->input('keyword')}}" class="form-control col-md-10" placeholder="Type here to search ...">
    </div>                
    

    <div class="row justify-content-center mb-3">
        <div class="col-md-4">
            <div class="form-group row justify-content-around">
                <label for="sort_by" class="col-md-4 col-form-label">Sort By</label>
                <select name="sort_by" id="sort_by" class="form-control col-md-7">
                    <option @if(request()->input('sort_by') === 'name') selected @endif value="name">Name</option>
                    <option @if(request()->input('sort_by') === 'username') selected @endif value="username">Username</option>
                    <option @if(request()->input('sort_by') === 'email') selected @endif value="email">Email</option>
                    <option @if(request()->input('sort_by') === 'roles_count') selected @endif value="roles_count">Roles count</option>
                    <option @if(request()->input('sort_by') === 'permissions_count') selected @endif value="permissions_count">Permissions count</option>
                    <option @if(request()->input('sort_by') === 'status') selected @endif value="status">Status</option>   
                    <option @if(request()->input('sort_by') === 'created_at' OR empty(request()->input('sort_by'))) selected @endif value="created_at">Created at</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group row justify-content-around">
                <label for="order_by" class="col-md-4 col-form-label">Order By</label>
                <select name="order_by" id="order_by" class="form-control col-md-7"> 
                    <option  @if(request()->input('order_by') === 'desc') selected @endif value="desc">Descending</option>           
                    <option  @if(request()->input('order_by') === 'asc') selected @endif value="asc">Ascending</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group row justify-content-around">
                <label for="limit_by" class="col-md-4 col-form-label">Limit By</label>
                <select name="limit_by" id="limit_by" class="form-control col-md-7">                                       
                    <option @if(request()->input('limit_by') === '10') selected @endif value="10">10</option>                            
                    <option @if(request()->input('limit_by') === '20' OR request()->input('limit_by') == null) selected @endif value="20">20</option>                            
                    <option @if(request()->input('limit_by') === '50') selected @endif value="50">50</option>                            
                    <option @if(request()->input('limit_by') === '100') selected @endif value="100">100</option>                     
                </select>
            </div>
        </div>
    </div>


    <div class="row mb-3 justify-content-center">
        <div class="col-md-4">
            <div class="form-group row justify-content-around">
                <label for="status" class="col-md-4 col-form-label">Status</label>
                <select name="status" id="status" class="form-control col-md-7">     
                    <option value="all">All</option>           
                    <option value="1" @if(request()->input('status') === '1') selected @endif>Active</option>                            
                    <option value="0" @if(request()->input('status') === '0') selected @endif>Inactive</option>                            
                </select>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group row justify-content-start">
                <label for="constraints" class="col-md-3 col-form-label">Constraints</label>
                <select name="constraints" id="constraints" class="form-control col-md-8">     
                    <option value="0" @if(request()->input('constraints') === '0' OR empty(request()->input('constraints'))) selected @endif>Must have those roles and permissions</option>                            
                    <option value="1" @if(request()->input('constraints') === '1') selected @endif>Exact roles</option>                            
                    <option value="2" @if(request()->input('constraints') === '2') selected @endif>Exact permissions</option>                            
                    <option value="3" @if(request()->input('constraints') === '3') selected @endif>Exact roles and permissions</option>                            
                </select>
            </div>
        </div>
    </div>

    <h3 class="text-center mb-2">Roles</h3>
    <div class="row mb-3">
        @if (!empty(request()->input('roles')))
            @foreach ($allRoles as $role)
                <div class="col-md-3 mb-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="roles[]" id="{{'role-' . $role->id}}" value="{{str_replace(' ', '_',$role->name)}}" @if(in_array($role->name, str_replace('_',' ',request()->input('roles')))) checked @endif>
                        <label class="form-check-label" for="{{'role-' . $role->id}}">{{$role->name}}</label>
                    </div>
                </div> 
            @endforeach 
        @else
            @foreach ($allRoles as $role)
                <div class="col-md-3 mb-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="roles[]" id="{{'role-' . $role->id}}" value="{{str_replace(' ', '_',$role->name)}}" >
                        <label class="form-check-label" for="{{'role-' . $role->id}}">{{$role->name}}</label>
                    </div>
                </div> 
            @endforeach 
        @endif

    </div>


    @foreach ($sections as $section)
        <div class="permission  mb-3">  
            @if ($loop->index == 0)
                <h3 class="text-center mb-2">Permissions</h3>
            @endif                                  
            <h6 class="text-uppercase my-1">{{$section->section}}</h6>
            <div class="row pl-4 pt-2">
                @if (!empty(request()->input('permissions')))                
                    @foreach($allPermissions as $permission)
                        @if($permission->section == $section->section)
                            <div class="col-md-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" id="{{'permission-' . $permission->id}}" value="{{str_replace(' ', '_',$permission->name)}}" @if(in_array($permission->name, str_replace('_',' ',request()->input('permissions'))))  checked @endif>
                                    <label class="form-check-label" for="{{'permission-' . $permission->id}}">{{$permission->name}}</label>
                                </div>
                            </div>                                       
                        @endif
                    @endforeach
                @else
                    @foreach($allPermissions as $permission)
                        @if($permission->section == $section->section)
                            <div class="col-md-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" id="{{'permission-' . $permission->id}}" value="{{str_replace(' ', '_',$permission->name)}}" >
                                    <label class="form-check-label" for="{{'permission-' . $permission->id}}">{{$permission->name}}</label>
                                </div>
                            </div>                                       
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach

    <div class="mx-auto text-center">
        {{-- <button type="submit" class="btn btn-warning">Click to search</button> --}}
        <a href="#" class="btn btn-warning btn-icon-split admin-btn">
            <span class="icon text-white-50">
                <i class="fas fa-search"></i>
            </span>
            <span class="text">Click to search</span>
        </a>
    </div>

</form>
        