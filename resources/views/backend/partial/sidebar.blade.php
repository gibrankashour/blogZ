<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.profile')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ auth()->user()->name }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(\illuminate\support\facades\route::is('admin.home')) active @endif">
        <a class="nav-link" href="{{route('admin.home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Main
    </div>
    @if (canAnyPermissions(['show categories', 'store category', 'edit category', 'delete category']))
        <!--  Categories Menu -->
        <li class="nav-item  @if(\illuminate\support\facades\route::is('admin.category.*')) active @endif">
            <a class="nav-link @if(!\illuminate\support\facades\route::is('admin.category.*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseCategories"
                aria-expanded="true" aria-controls="collapseCategories">
                <i class="fas fa-fw fa-list-alt"></i>
                <span>Categories</span>
            </a>
            <div id="collapseCategories" class="collapse @if(\illuminate\support\facades\route::is('admin.category.*')) show @endif" aria-labelledby="headingCategories" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Categories:</h6> 
                    @if (canAnyPermissions(['show categories', 'edit category', 'delete category']))
                        <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.category.all')) active @endif" href="{{ route('admin.category.all') }}">All categories</a>
                    @endif               
                    @can('store category')
                        <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.category.create')) active @endif" href="{{ route('admin.category.create') }}">Create category</a>
                    @endcan 
                    @if(\illuminate\support\facades\route::is('admin.category.edit') && auth()->user()->can('edit category') && !empty($category)) 
                        <a href="{{route('admin.category.edit', $category->slug)}}" class="collapse-item active" title="{{ $category->name }}">Edit category</a>
                    @endif
                </div>
            </div>
        </li>
    @endif

    @if (canAnyPermissions(['show users', 'store user', 'edit user', 'delete user']))
        <!-- Users Menu -->
        <li class="nav-item @if(\illuminate\support\facades\route::is('admin.user.*')) active @endif">
            <a class="nav-link @if(!\illuminate\support\facades\route::is('admin.user.*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseUsers"
                aria-expanded="true" aria-controls="collapseUsers">
                <i class="fas fa-fw fa-users"></i>
                <span>Users</span>
            </a>
            <div id="collapseUsers" class="collapse @if(\illuminate\support\facades\route::is('admin.user.*')) show @endif" aria-labelledby="headingUsers"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Users:</h6>
                    @if (canAnyPermissions(['show users', 'edit user', 'delete user']))
                        <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.user.all')) active @endif" href="{{ route('admin.user.all') }}">All users</a>
                    @endif
                    @can('store user')
                        <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.user.create')) active @endif" href="{{ route('admin.user.create') }}">Create user</a>
                    @endcan                    
                    @if(\illuminate\support\facades\route::is('admin.user.edit') && auth()->user()->can('edit user')) 
                        <a href="{{route('admin.user.edit', $user->username)}}" class="collapse-item active" title="{{ $user->name }}">Edit user ({{ $user->name }})</a>
                    @endif
                </div>
            </div>
        </li>
    @endif

    @if (canAnyPermissions(['show posts', 'store post', 'edit post', 'delete post']))
        <!-- Posts Menu -->
        <li class="nav-item @if(\illuminate\support\facades\route::is('admin.post.*')) active @endif">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePosts"
                aria-expanded="true" aria-controls="collapsePosts">
                <i class="fas fa-fw fa-newspaper"></i>
                <span>Posts</span>
            </a>
            <div id="collapsePosts" class="collapse @if(\illuminate\support\facades\route::is('admin.post.*')) show @endif" aria-labelledby="headingPosts"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Posts:</h6>
                    @if (canAnyPermissions(['show posts', 'edit post', 'delete post']))
                        <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.post.all')) active @endif" href="{{route('admin.post.all')}}">All posts</a>
                    @endif
                    @can('store post')
                        <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.post.create')) active @endif" href="{{ route('admin.post.create') }}">Create post</a>
                    @endcan 
                    @if(\illuminate\support\facades\route::is('admin.post.edit') && auth()->user()->can('edit post') && !empty($post)) 
                        <a href="{{route('admin.post.edit', $post->slug)}}" class="collapse-item active" title="{{ $post->name }}">Edit post</a>
                    @endif                    
                    @if(\illuminate\support\facades\route::is('admin.post.show') && auth()->user()->can('show posts') && !empty($post)) 
                        <a href="{{route('admin.post.show', $post->slug)}}" class="collapse-item active" title="{{ $post->name }}">Show post</a>
                    @endif                    
                </div>
            </div>
        </li>
    @endif

    @if (canAnyPermissions(['show comments', 'activate comment', 'delete comment']))
        <!-- Comments  -->
        <li class="nav-item @if(\illuminate\support\facades\route::is('admin.comment.*')) active @endif">
            <a class="nav-link" href="{{route('admin.comment.all')}}">
                <i class="fas fa-fw fa-comments"></i>
                <span> Comments</span>
            </a>
        </li>    
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    
    <div class="sidebar-heading">
        Pages and Contact Us 
    </div>
    @if (canAnyPermissions(['show pages', 'edit page']))
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item @if(\illuminate\support\facades\route::is('admin.page.*')) active @endif">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse @if(\illuminate\support\facades\route::is('admin.page.*')) show @endif" aria-labelledby="headingPages"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Fixed Pages:</h6>                    
                    <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.page.edit')  && !empty($page) && $page->slug == 'about_us') active @endif" href="{{route('admin.page.edit', 'about_us')}}">About us</a>            
                    <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.page.edit')  && !empty($page) && $page->slug == 'our_vision') active @endif" href="{{route('admin.page.edit', 'our_vision')}}">Our vision </a>                  
                </div>
            </div>
        </li>
    @endif

    @if (canAnyPermissions(['show contacts', 'replay contact', 'delete contacts']))
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item @if(\illuminate\support\facades\route::is('admin.contact.*')) active @endif">
            <a class="nav-link @if(!\illuminate\support\facades\route::is('admin.contact.*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseContact" aria-expanded="true"
                aria-controls="collapseContact">
                <i class="fas fa-fw fa-folder"></i>
                <span>Contact Us</span>
            </a>
            <div id="collapseContact" class="collapse @if(\illuminate\support\facades\route::is('admin.contact.*')) show @endif" aria-labelledby="headingContact"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Contact Us</h6>
                    <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.contact.all')) active @endif" href="{{ route('admin.contact.all') }}">All messages</a>
                    @if(\illuminate\support\facades\route::is('admin.contact.replay') && !empty($contact)) 
                        <a href="{{route('admin.contact.replay', $contact->id)}}" class="collapse-item active" title="{{ $contact->title }}">Replay message (#{{ $contact->id }})</a>
                    @endif
                </div>
            </div>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Website 
    </div>

    @hasanyrole('admins|super admin')
        <!-- Admins Menu -->
        <li class="nav-item @if(\illuminate\support\facades\route::is('admin.admin.*')) active @endif">
            <a class="nav-link @if(!\illuminate\support\facades\route::is('admin.admin.*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseAdmins"
                aria-expanded="true" aria-controls="collapseAdmins">
                <i class="fas fa-fw fa-users"></i>
                <span>Admins</span>
            </a>
            <div id="collapseAdmins" class="collapse @if(\illuminate\support\facades\route::is('admin.admin.*')) show @endif" aria-labelledby="headingAdmins"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Admins:</h6>
                    <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.admin.all')) active @endif" href="{{ route('admin.admin.all') }}">All admins</a>
                    <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.admin.create')) active @endif" href="{{ route('admin.admin.create') }}">Create admin</a>
                    @if(\illuminate\support\facades\route::is('admin.admin.show') && !empty($admin)) 
                        <a href="{{route('admin.admin.show', $admin->id)}}" class="collapse-item active" title="{{ $admin->name }}">Show admin ({{ $admin->name }})</a>
                    @endif
                    @if(\illuminate\support\facades\route::is('admin.admin.edit') && !empty($admin)) 
                        <a href="{{route('admin.admin.edit', $admin->username)}}" class="collapse-item active" title="{{ $admin->name }}">Edit admin ({{ $admin->name }})</a>
                    @endif
                </div>
            </div>
        </li>
    @endrole

    @if (canAnyPermissions(['show roles', 'store role', 'edit role', 'delete role']))
        <!-- Roles Menu -->
        <li class="nav-item @if(\illuminate\support\facades\route::is('admin.role.*')) active @endif">
            <a class="nav-link @if(!\illuminate\support\facades\route::is('admin.role.*')) collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseRoles"
                aria-expanded="true" aria-controls="collapseRoles">
                <i class="fas fa-fw fa-users"></i>
                <span>Roles</span>
            </a>
            <div id="collapseRoles" class="collapse @if(\illuminate\support\facades\route::is('admin.role.*')) show @endif" aria-labelledby="headingRoles"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Roles:</h6>
                    <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.role.all')) active @endif" href="{{ route('admin.role.all') }}">All roles</a>
                    @can('store role')
                        <a class="collapse-item @if(\illuminate\support\facades\route::is('admin.role.create')) active @endif" href="{{ route('admin.role.create') }}">Create role</a>
                    @endcan
                    
                    @if(\illuminate\support\facades\route::is('admin.role.show') && !empty($role) && auth()->user()->can('show roles')) 
                        <a href="{{route('admin.role.show', $role->id)}}" class="collapse-item active" title="{{ $role->name }}">Show role ({{ $role->name }})</a>
                    @endif
                    @if(\illuminate\support\facades\route::is('admin.role.edit') && !empty($role) && auth()->user()->can('edit role')) 
                        <a href="{{route('admin.role.edit', $role->id)}}" class="collapse-item active" title="{{ $role->name }}">Edit role ({{ $role->name }})</a>
                    @endif
                </div>
            </div>
        </li>   
    @endif

    @if (canAnyPermissions(['show settings', 'edit setting',]))
        <!-- Settings  -->
        <li class="nav-item @if(\illuminate\support\facades\route::is('admin.settings')) active @endif">
            <a class="nav-link" href="{{route('admin.settings')}}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span> Settings</span>
            </a>
        </li> 
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>