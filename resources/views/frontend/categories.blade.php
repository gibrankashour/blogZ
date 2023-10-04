@extends('layouts.app')

@section('content')

<!-- Start Categories Area -->
<section class="wn__team__area pt--40 pb--75 bg--white">
    <div class="container">
        <h2 class="text-center">All Categories</h2>
        <div class="row">
            @foreach ($allCategories as $category)
                <!-- Start Category Team -->
                <div class="col-lg-3">
                    <div class="wn__team text-center">
                        <div class="thumb">
                            @if ($category->category_image != null)
                                <a href="{{ route('category.show', $category->name) }}">
                                    <img src="{{ asset('assets/categories/' . $category->category_image) }}" alt="{{$category->name}}">
                                </a>
                            @else
                                <a href="{{ route('category.show', $category->name) }}">
                                    <img src="{{ asset('assets/default/category.jpg') }}" alt="{{$category->name}}">
                                </a>
                            @endif                            
                        </div>
                        <div class="content">
                            <h4> <a href="{{ route('category.show', $category->name) }}"> {{$category->name}} ( {{$category->posts_count}} )</a></h4>
                        </div>
                    </div>
                </div>
                <!-- End Category Team -->               
            @endforeach

        </div>
    </div>
</section>
<!-- End Categories Area -->
    
@endsection