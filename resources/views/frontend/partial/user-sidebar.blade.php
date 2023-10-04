<div class="wn__sidebar">

    <!-- Start Single Widget -->
    <aside class="widget recent_widget ">
        <ul class="shadow-1" style="border-radius: 0.25rem;">
        <li class="list-group-item">
            <img src="@if(auth()->user()->user_image != '')  {{ asset('assets/users/' . auth()->user()->user_image) }} @else  {{ asset('assets/default/user.jpg') }} @endif" alt="{{ auth()->user()->name }}">
        </li>

        <li class="user-dashboard-item"><a href="{{ route('dashboard.home') }}" class="@if(request()->routeIs('dashboard.home')) active  @endif">My Dashboard</a></li>
        <li class="user-dashboard-item"><a href="{{ route('dashboard.allPosts') }}" class="@if(request()->routeIs('dashboard.allPosts')) active  @endif">My Posts</a></li>
        <li class="user-dashboard-item"><a href="{{ route('dashboard.createPost') }}" class="@if(request()->routeIs('dashboard.createPost')) active  @endif">Create Post</a></li>
        <li class="user-dashboard-item"><a href="{{ route('dashboard.allComments') }}">Manage Comments</a></li>
        <li class="user-dashboard-item"><a href="{{ route('dashboard.myInformation') }}" class="@if(request()->routeIs('dashboard.myInformation')) active  @endif">Update Information</a></li>
        <li class="user-dashboard-item"><a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        </ul>
    </aside>
    <!-- End Single Widget -->

</div>