
<form action="{{ route('admin.role.all') }}" method="GET" class="admin-form">

    <div class="form-group row mb-3 pb-3 px-3">
        <label for="keyword" class="col-md-2 col-form-label">Search Field</label>                
        <input type="text" name="keyword" value="{{request()->input('keyword')}}" class="form-control col-md-10" placeholder="Type here to search ...">
    </div>                
    
    <div class="row mb-3 justify-content-center">
        <div class="col-md-4 mr-5">
            <div class="form-group row">
                <label for="deletable" class="col-md-4 col-form-label">Deletable</label>
                <select name="deletable" id="deletable" class="form-control col-md-8">     
                    <option value="all">All</option>           
                    <option value="1" @if(request()->input('deletable') === '1') selected @endif>Deletable</option>                            
                    <option value="0" @if(request()->input('deletable') === '0') selected @endif>Undeletable</option>                            
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group row">
                <label for="sort_by" class="col-md-4 col-form-label">Sort By</label>
                <select name="sort_by" id="sort_by" class="form-control col-md-8">
                    <option @if(request()->input('sort_by') === 'name') selected @endif value="name">Name</option>
                    <option @if(request()->input('sort_by') === 'guard_name') selected @endif value="username">Guard name</option>
                    <option @if(request()->input('sort_by') === 'created_at' OR empty(request()->input('sort_by'))) selected @endif value="created_at">Created at</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-3">
        <div class="col-md-4 mr-5">
            <div class="form-group row">
                <label for="order_by" class="col-md-4 col-form-label">Order By</label>
                <select name="order_by" id="order_by" class="form-control col-md-8"> 
                    <option  @if(request()->input('order_by') === 'desc') selected @endif value="desc">Descending</option>           
                    <option  @if(request()->input('order_by') === 'asc') selected @endif value="asc">Ascending</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group row">
                <label for="limit_by" class="col-md-4 col-form-label">Limit By</label>
                <select name="limit_by" id="limit_by" class="form-control col-md-8">                                       
                    <option @if(request()->input('limit_by') === '10') selected @endif value="10">10</option>                            
                    <option @if(request()->input('limit_by') === '20' OR request()->input('limit_by') == null) selected @endif value="20">20</option>                            
                    <option @if(request()->input('limit_by') === '50') selected @endif value="50">50</option>                            
                    <option @if(request()->input('limit_by') === '100') selected @endif value="100">100</option>                     
                </select>
            </div>
        </div>
    </div>
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
        