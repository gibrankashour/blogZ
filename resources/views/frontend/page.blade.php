@extends('layouts.app')

@section('content')

<!-- Start Blog Area -->
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">

                @if ($post != null)

                <div class="blog-details content">
                    <article class="blog-post-details">
                        
                        <div class="post_wrapper">
                            <div class="post_header">
                                <h2>{{ $post->title }}</h2>
                            </div>
                            @if ($post->post_cover != null)
                                    <img src={{asset("assets/pages/" . $post->post_cover)}} alt="{{ $post->title }}" class="fit fit-500 mb-4">
                            @endif
                            <div class="post_content">
                                {!! $description !!}
                            </div>
                        </div>
                    </article>
                </div>

                @else
                    <h2 class="text-danger"> We didn't find the specific post!! </h2>
                @endif

            </div>

        </div>
    </div>
</div>
<!-- End Blog Area -->

@endsection