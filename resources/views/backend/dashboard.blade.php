@extends('layouts.admin')

@section('style')

@endsection

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id='test-ajax'><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Posts</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalPosts}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-fw fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Pindeins Posts</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalPendingPosts}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-fw fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalUsers}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-fw fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Pending Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalPendingUsers}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-fw fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

<div class="row align-items-center">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Posts and Comments count</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in area-chart-options"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Time scale:</div>
                        <a class="dropdown-item active" href="#" data-time='week'>Last 7 dayes</a>
                        <a class="dropdown-item" href="#" data-time='month'>Las 30 dayes</a>
                        <a class="dropdown-item " href="#" data-time='year'>Last year</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Categories with the most posts</h6>
                <div class="dropdown no-arrow">
                    {{-- <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div> --}}
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row align-items-center">

    <div class="col-lg-6 mb-4">
        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Latest five posts</h6>
            </div>
            <div class="card-body">
                @forelse($latestFivePosts as $post)
                <div class="d-flex justify-content-between align-items-center p-0 last-five-posts">
                    <h4 class="small font-weight-bold">{{$post->title}}</h4>
                    @can('edit post')
                        @if($post->status == 0 )
                        <a href="{{ route('admin.post.status', [$post->slug, 'approve']) }}" class="btn btn-warning active-post shaddow">Approve </a>
                        {{-- <a href="{{ route('admin.post.status', [$post->slug, 'approve']) }}" class="btn btn-secondary btn-icon-split mb-1">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>      
                            <span class="text">Approve</span>                              
                        </a> --}}
                        @endif
                    @endcan
                </div>                
                    <p>{!!\illuminate\support\str::limit(str_replace('[img][/img]','',$post->description), 150)!!}</p>
                        @if (canAnyPermissions(['show posts']))
                            <a rel="nofollow" href="{{route('admin.post.show', $post->slug)}}"> read more </a>
                        @endif
                        @if($loop->index != 4 )
                            <hr>
                        @endif
                    @empty

                @endforelse                
            </div>
        </div>
    </div>
    <!-- Content Column -->
    <div class="col-lg-6 mb-4">
        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">New posts count in the last week in top 5 categories</h6>
            </div>
            <div class="card-body">
                {{-- {!!$categoriesPercent!!} --}}
                @forelse ($categoriesPercent as $category)
                    <h4 class="small font-weight-bold">{{$category['category']}} - {{$category['count']}} posts <span class="float-right">{{$category['percent']}}%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{$category['percent']}}%"
                            aria-valuenow="{{$category['percent']}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    @empty
                    There are no posts created at last week
                @endforelse 
            </div>
        </div>
        <!-- Illustrations -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Last post</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    @if ($latestPost->post_cover != null)
                        <img src={{asset("assets/posts/" . $latestPost->post_cover)}} alt="{{ $latestPost->title }}" class="mt-3 mb-4 fit fit-300">
                    @else
                        <img src={{asset("assets/default/post.jpg")}} alt="{{ $latestPost->title }}" class="mt-3 mb-4 fit fit-300">
                    @endif                    
                </div>
                <p>{!!\illuminate\support\str::limit(str_replace('[img][/img]','',$latestPost->description), 350)!!}</p>
                @if (canAnyPermissions(['show posts']))
                    <a rel="nofollow" href="{{route('admin.post.show', $latestPost->slug)}}"> read more </a>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')

    <!-- Page level plugins -->
    <script src="{{asset('backend/vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('backend/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('backend/js/demo/chart-pie-demo.js')}}"></script>

@endsection