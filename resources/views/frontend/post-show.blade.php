@extends('layouts.app')

@section('content')
{{-- {{dd($post)}} --}}
<!-- Start Blog Area -->

<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                @if(!empty($post) && auth()->check()  && $post->user_id == auth()->user()->id && $post->status == 0)

                    <div class="blog-details content">

                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-4">
                                <p class="text-warning text-center">
                                    <span class="shadow-1 py-3 px-4 rounded" style="display: inline-block;">
                                        <strong> This post is InActive, only you can see it  </strong>
                                    </span>
                                </p>
                            </div>
                        </div>

                        <article class="blog-post-details">
                            <div class="post-thumbnail">
                                @if (isset($post->media->first()->file_name))
                                    <img src={{asset("assets/" . $post->media->first()->file_name)}} alt="{{ $post->title }}" class="fit fit-500">
                                @else
                                    <img src={{asset("assets/default/post.jpg")}} alt="{{ $post->title }}" class="fit fit-500">
                                @endif 
                            </div>
                            <div class="post_wrapper">
                                <div class="post_header">
                                    <h2>{{ $post->title }}</h2>
                                    <div class="blog-date-categori">
                                        <ul>
                                            <li>{{$post->created_at->format('M j\, Y')}}
                                                @if ($post->created_at != $post->updated_at)
                                                    / <span class="text-success">Last update : {{$post->updated_at->format('M j\, Y')}}</span>    
                                                @endif
                                            </li>
                                            <li><a href="{{ route('user.posts.show', ['username' => $post->user->username]) }}" title="Posts by boighor" rel="author">{{$post->user->name}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="post_content">
                                    {!! $post->description !!}
                                </div>
                                <ul class="blog_meta">
                                    <li><span>Category</span> : {{$post->category->name}}</li>
                                </ul>
                            </div>
                        </article>

                        <div class="comment_respond" id="comment_area">
                            <p class="text-warning">This post's status is <strong>InActive</strong> so you can <strong>not</strong> write comments </p>
                        </div>

                        @if($post->approved_comments_count > 0)
                            <div class="comments_area">                            
                                <h3 class="comment__title">{{$post->approved_comments_count}} comment(s)</h3>

                                @include('frontend.partial.comments', ['comments' => $post->approvedParentComments, 'postAuthorID' => $post->user->id])
                            </div>
                        @else
                        <div class="comments_area">
                            <h3 class="comment__title"> There are no comments in this post!</h3>
                        </div>        
                        @endif

                    </div>

                @elseif ($post != null)
                    <div class="d-none post-slug">{{$post->slug}}</div>
                    <div class="blog-details content">
                        <article class="blog-post-details">
                            <div class="post-thumbnail">
                                @if ($post->post_cover != null)
                                    <img src={{asset("assets/posts/" . $post->post_cover)}} alt="{{ $post->title }}" class="fit fit-500">
                                @else
                                    <img src={{asset("assets/default/post.jpg")}} alt="{{ $post->title }}" class="fit fit-500">
                                @endif 
                            </div>
                            <div class="post_wrapper">
                                <div class="post_header">
                                    <h2>{{ $post->title }}</h2>
                                    <div class="blog-date-categori">
                                        <ul>
                                            <li>{{$post->created_at->format('M j\, Y')}}
                                                @if ($post->created_at != $post->updated_at)
                                                    / <span class="text-success">Last update : {{$post->updated_at->format('M j\, Y')}}</span>    
                                                @endif
                                            </li>
                                            <li><a href="{{ route('user.posts.show', ['username' => $post->user->username]) }}" title="Posts by boighor" rel="author">{{$post->user->name}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="post_content">                                                                     
                                    {!! $description !!}
                                </div>
                                <ul class="blog_meta">
                                    <li><span>Category</span> : {{$post->category->name}}</li>
                                </ul>
                            </div>
                        </article>

                        <div class="comment_respond" id="comment_area">
                            <h3 class="reply_title">Leave a Reply</h3>
                            <form class="comment__form" action="{{route('comment.store', $post->slug)}}" method="GET">
                                
                                <input type="hidden" value="" name="comment_id" />
                                <p>Your email address will not be published. All fields are marked </p>
                                <div class="input__wrapper clearfix">
                                    <div class="input__box name one--third">
                                        <input class="shadow-2" name="name" type="text" placeholder="name" value="{{old('name',auth()->check() ? auth()->user()->name : '')}}" 
                                            @if (auth()->check() && auth()->user()->id == $post->user->id)
                                                readonly
                                            @endif
                                        >
                                        @error('name')
                                            <span class="error-input text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="input__box email one--third">
                                        <input class="shadow-2" name="email" type="email" placeholder="email"  value="{{old('email',auth()->check() ? auth()->user()->email : '')}}"
                                        @if (auth()->check() && auth()->user()->id == $post->user->id)
                                            readonly
                                        @endif
                                        >
                                        @error('email')
                                            <span class="error-input text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="input__box website one--third">
                                        <input name="comment_id" type="hidden" value="">                                    
                                    </div>
                                </div>
                                <div class="input__box">
                                    <textarea class="shadow-2" name="comment" placeholder="Your comment here">{{old('comment')}}</textarea>
                                    @error('comment')
                                        <span class="error-input text-danger">{{$message}}</span>
                                    @enderror
                                </div>                            
                                <div class="submite__btn">                                    
                                    <input type="submit" value="Post Comment"  data-comment="main"/>
                                </div>
                            </form>
                        </div>
                        
                        
                        @if($post->approved_comments_count > 0)
                            <div class="comments_area">                            
                                <h3 class="comment__title">{{$post->approved_comments_count}} comment(s)</h3>

                                @include('frontend.partial.comments', ['comments' => $post->approvedParentComments, 'postAuthorID' => $post->user->id])
                            </div>
                        @else
                        <div class="comments_area">
                            <h3 class="comment__title"> There are no comments in this post!</h3>
                        </div>        
                        @endif

                    </div>

                @else
                    <h2 class="text-danger"> We didn't find the specific post!! </h2>
                @endif

            </div>

            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                @include('frontend.partial.sidebar')
            </div>
        </div>
    </div>
</div>
<!-- End Blog Area -->

@endsection

@section('script')
    <script src="{{ asset('frontend/js/ajax.js') }}"></script>
@endsection