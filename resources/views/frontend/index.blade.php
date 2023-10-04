@extends('layouts.app')

@section('content')
{{-- {{dd(request()->search)}} --}}
<!-- Start Blog Area -->
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="blog-page">
                    @if (isset($viewType) && $viewType != null)
                    <div class="page__header">
                        @if ($viewType == 'archive')
                            <h2>Posts in : {{ date('F Y', mktime(0, 0, 0, $month, 1, $year)) }}</h2>
                        @elseif ($viewType == 'category')
                            <h2>Posts in category : {{ $categoryName }}</h2>
                        @elseif ($viewType == 'user' && $posts->isNotEmpty())
                            <h2>Posts by user : {{ $posts->first()->user->name }}</h2>                          
                        @endif                        
                    </div>     
                    @endif

                    @if (request()->search != null)
                        <div class="page__header"> 
                            <h2>Results for : {{ request()->search }}</h2>
                        </div> 
                    @endif        

                    @forelse ($posts as $post)
                        
                        <article class="blog__post d-flex flex-wrap">
                            <div class="thumb index-page-thumb shadow-1">
                                <a href="{{ route('post.show', $post->slug) }}">
                                    @if ($post->post_cover != null)
                                        <img src={{asset("assets/posts/" . $post->post_cover)}} alt="{{ $post->title }}" class="fit-300 fit index-page-image">
                                    @else
                                        <img src={{asset("assets/default/post.jpg")}} alt="{{ $post->title }}" class="fit-300 fit index-page-image">
                                    @endif  
                                </a>
                            </div>
                            <div class="content">
                                <h4 class="post-title"><a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a></h4>
                                <ul class="post__meta">
                                    <li>Posts by : <a href="{{ route('user.posts.show', ['username' => $post->user->username]) }}">{{ $post->user->name }}</a></li>
                                    <li class="post_separator">/</li>
                                    <li>{{ $post->updated_at->format('M j Y') }}</li>
                                </ul>
                                <p>{!! Illuminate\Support\Str::limit(str_replace('[img][/img]','',$post->description), 250) !!}</p>
                                <div class="blog__btn">
                                    <a href="{{ route('post.show', $post->slug) }}">read more</a>
                                </div>
                            </div>
                        </article>
                               
                    @empty
                        <h2>There are No posts to show!</h2>
                    @endforelse
                    
                </div>
                
                {{$posts->links('vendor.pagination.boighor')}}                
                                
            </div>
            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                @include('frontend.partial.sidebar')
            </div>
        </div>
    </div>
</div>
<!-- End Blog Area -->

@endsection