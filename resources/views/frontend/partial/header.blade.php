<!-- Header -->
<header id="wn__header" class="oth-page header__area header__absolute sticky__header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-7 col-lg-2">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src={{asset("frontend/images/logo/logo.png")}} alt="logo images">
                    </a>
                </div>
            </div>
            <div class="col-lg-8 d-none d-lg-block">
                <nav class="mainmenu__nav">
                    <ul class="meninmenu d-flex justify-content-start">
                        <li class="drop with--one--item"><a href="{{ route('home') }}" class="@if(\illuminate\support\facades\route::is('home')) active @endif">Home</a></li>
                        <li class="drop"><a href="{{ route('categories') }}" class="@if(\illuminate\support\facades\route::is('categories')) active @endif">Categories</a>
                            <div class="megamenu dropdown">
                                <ul class="item item01">                                           
                                    @forelse ($categories as $category)
                                        <li>
                                            <a href="{{ route('category.show', $category->name) }}"
                                                class="{{isset($categoryName) && $categoryName == $category->name?'active':''}}">
                                            {{ $category->name }}
                                            </a>
                                        </li>
                                    @empty
                                        <li>No Categories Found!!</li>
                                    @endforelse
                                    
                                    @if ($categories != null)
                                        <li><a href="{{ route('categories') }}">Show all categories</a></li>
                                    @endif
                                </ul>
                            </div>
                        </li>
                        <li><a href="{{ route('page', 'about_us') }}" class="@if(\illuminate\support\facades\route::is('page') && !empty($post) && $post->slug == 'about_us') active @endif">About Us</a></li>
                        <li><a href="{{ route('page', 'our_vision') }}" class="@if(\illuminate\support\facades\route::is('page') && !empty($post) && $post->slug == 'our_vision') active @endif">Our vision</a></li>
                        <li><a href="{{ route('contact') }}" class="@if(\illuminate\support\facades\route::is('contact')) active @endif">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-8 col-sm-8 col-5 col-lg-2">
                <ul class="header__sidebar__right d-flex justify-content-end align-items-center">
                    <li class="shop_search"><a class="search__active" href="#"><i class="text-white header-icon icon-magnifier icons"></i></a></li>
                    
                    {{-- <li class="shopcart"><a class="cartbox_active" href="#"><span class="product_qun">3</span></a>
                        <!-- Start Shopping Cart -->
                        <div class="block-minicart minicart__active">
                            <div class="minicart-content-wrapper">
                                <div class="micart__close">
                                    <span>close</span>
                                </div>
                                <div class="items-total d-flex justify-content-between">
                                    <span>3 items</span>
                                    <span>Cart Subtotal</span>
                                </div>
                                <div class="total_amount text-right">
                                    <span>$66.00</span>
                                </div>
                                <div class="mini_action checkout">
                                    <a class="checkout__btn" href="cart.html">Go to Checkout</a>
                                </div>
                                <div class="single__items">
                                    <div class="miniproduct">
                                        <div class="item01 d-flex">
                                            <div class="thumb">
                                                <a href="product-details.html"><img src={{asset("frontend/images/product/sm-img/1.jpg")}} alt="product images"></a>
                                            </div>
                                            <div class="content">
                                                <h6><a href="product-details.html">Voyage Yoga Bag</a></h6>
                                                <span class="prize">$30.00</span>
                                                <div class="product_prize d-flex justify-content-between">
                                                    <span class="qun">Qty: 01</span>
                                                    <ul class="d-flex justify-content-end">
                                                        <li><a href="#"><i class="zmdi zmdi-settings"></i></a></li>
                                                        <li><a href="#"><i class="zmdi zmdi-delete"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item01 d-flex mt--20">
                                            <div class="thumb">
                                                <a href="product-details.html"><img src={{asset("frontend/images/product/sm-img/3.jpg")}} alt="product images"></a>
                                            </div>
                                            <div class="content">
                                                <h6><a href="product-details.html">Impulse Duffle</a></h6>
                                                <span class="prize">$40.00</span>
                                                <div class="product_prize d-flex justify-content-between">
                                                    <span class="qun">Qty: 03</span>
                                                    <ul class="d-flex justify-content-end">
                                                        <li><a href="#"><i class="zmdi zmdi-settings"></i></a></li>
                                                        <li><a href="#"><i class="zmdi zmdi-delete"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item01 d-flex mt--20">
                                            <div class="thumb">
                                                <a href="product-details.html"><img src={{asset("frontend/images/product/sm-img/2.jpg")}} alt="product images"></a>
                                            </div>
                                            <div class="content">
                                                <h6><a href="product-details.html">Compete Track Tote</a></h6>
                                                <span class="prize">$40.00</span>
                                                <div class="product_prize d-flex justify-content-between">
                                                    <span class="qun">Qty: 03</span>
                                                    <ul class="d-flex justify-content-end">
                                                        <li><a href="#"><i class="zmdi zmdi-settings"></i></a></li>
                                                        <li><a href="#"><i class="zmdi zmdi-delete"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mini_action cart">
                                    <a class="cart__btn" href="cart.html">View and edit cart</a>
                                </div>
                            </div>
                        </div>
                        <!-- End Shopping Cart -->
                    </li> --}}
                    
                    <li class="setting__bar__icon mx-4"><a class="setting__active" href="#"><i class="text-white header-icon icon-user icons"></i></a>
                        <div class="searchbar__content setting__block">
                            <div class="content-inner">
                                
                                <div class="switcher-currency">
                                    <strong class="label switcher-label">
                                        <span>My Account</span>
                                    </strong>

                                    <div class="switcher-options">
                                        <div class="switcher-currency-trigger">
                                            <div class="setting__menu">
                                                @guest
                                                    @if (Route::has('login'))
                                                        <span><a href="{{ route('login') }}">{{ __('Login') }}</a></span>
                                                    @endif
                                
                                                    @if (Route::has('register'))
                                                        <span><a href="{{ route('register') }}">{{ __('Register') }}</a></span>
                                                    @endif
                                                @else
                                                    <span><a href="{{ route('dashboard.home') }}">{{ Auth::user()->name }}</a></span>
                                                    <span><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a></span>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                @endguest
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Start Mobile Menu -->
        <div class="row d-none">
            <div class="col-lg-12 d-none">
                <nav class="mobilemenu__nav">
                    <ul class="meninmenu">
                        <li><a href="{{ route('home') }}" class="">Home</a></li>
                        @auth
                        <span><a href="{{ route('dashboard.home') }}">{{ Auth::user()->name }}</a></span>
                        <span><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a></span>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        
                        @endauth
                        <li><a href="{{ route('categories') }}">Categories</a>
                            <ul>
                                @forelse ($categories as $category)
                                    <li>
                                        <a href="{{ route('category.show', $category->name) }}"
                                            class="{{isset($categoryName) && $categoryName == $category->name?'active':''}}">
                                        {{ $category->name }}
                                        </a>
                                    </li>
                                @empty
                                    <li>No Categories Found!!</li>
                                @endforelse
                                
                                @if ($categories != null)
                                    <li><a href="{{ route('categories') }}">Show all categories</a></li>
                                @endif                              
                            
                            </ul>
                        </li>
                        
                        <li><a href="{{ route('page', 'about_us') }}" class="@if(\illuminate\support\facades\route::is('page') && !empty($post) && $post->slug == 'about_us') active @endif">About Us</a></li>
                        <li><a href="{{ route('page', 'our_vision') }}" class="@if(\illuminate\support\facades\route::is('page') && !empty($post) && $post->slug == 'our_vision') active @endif">Our vision</a></li>
                        <li><a href="{{ route('contact') }}" class="@if(\illuminate\support\facades\route::is('contact')) active @endif">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- End Mobile Menu -->
        <div class="mobile-menu d-block d-lg-none">
        </div>
        <!-- Mobile Menu -->	
    </div>		
</header>
<!-- //Header -->
<!-- Start Search Popup -->
<div class="box-search-content search_active block-bg close__top">
    <form id="search_mini_form" class="minisearch srearch-form" action="{{route('home')}}" method="GET">
        <div class="field__search">
            <input type="text" placeholder="Search entire store here..." name="search" value="{{request()->search != null ? request()->search:''}}">
            <div class="action">
                {{-- <button type="submit"><i class="zmdi zmdi-search"></i></button> --}}
                <a href="#"><i class="zmdi zmdi-search"></i></a>
            </div>
        </div>
    </form>
    <div class="close__wrap">
        <span>close</span>
    </div>
</div>
<!-- End Search Popup -->
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area bg-image--4"
    @if(false)
    @elseif(\illuminate\support\facades\route::is('dashboard.*') && auth()->check() && auth()->user()->cover_image != null)
        style='background-image: url({{asset("assets/covers/" . auth()->user()->cover_image )}})'
    @else
        style='background-image: url({{asset("assets/website/" . getSetting("website_cover") )}})'
    @endif
    >
    <div class="container" style="top: -40px;position: relative;">
        <div class="row">
            <div class="col-lg-12">
                <div class="bradcaump__inner text-center">
                    <h2 class="bradcaump-title text-shadow">BlogZ</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->




{{-- 
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
 --}}