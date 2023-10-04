
{{-- {{dd($recent_posts)}} --}}
<div class="wn__sidebar">
    <!-- Start Single Widget -->
    <aside class="widget search_widget">
        <h3 class="widget-title">Search</h3>
        <form action="{{route('home')}}" method="GET">
            <div class="form-input">
                <input type="text" placeholder="Search..." name="search" value="{{request()->search != null ? request()->search:''}}">
                <button type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </aside>
    <!-- End Single Widget -->
    <!-- Start Single Widget -->
    <aside class="widget recent_widget">
        <h3 class="widget-title">Recent Posts</h3>
        <div class="recent-posts">
            <ul>
                @forelse($recent_posts as $post)
                    <li>
                        <div class="post-wrapper d-flex">
                            <div class="thumb">
                                <a href="{{ route('post.show', $post->slug) }}">
                                    @if ($post->media->count() > 0)
                                        <img src={{asset("assets/posts/" . $post->media->first()->file_name)}} alt="{{ $post->title }}" class="fit fit-50">
                                    @else
                                        <img src={{asset("assets/default/post-small.jpg")}} alt="{{ $post->title }}" class="fit fit-50">
                                    @endif
                                </a>
                            </div>
                            <div class="content">
                                <h4><a href="{{ route('post.show', $post->slug) }}">{!! Illuminate\Support\Str::limit( $post->title, 25)  !!}</a></h4>
                                <p>	{{ $post->updated_at->format('M j, Y') }}</p>
                            </div>
                        </div>
                    </li>
                @empty
                    <li>No Posts Found!!</li>
                @endforelse
            </ul>
        </div>
    </aside>
    <!-- End Single Widget -->
    <!-- Start Single Widget -->
    <aside class="widget comment_widget">
        <h3 class="widget-title">Comments</h3>
        <ul>
            @forelse($recent_comments as $comment)
            <li>
                <div class="post-wrapper">
                    <div class="thumb">
                        <a href="{{ route('post.show', $comment->post->slug) }}">
                            @if ( $comment->user != null && $comment->user->user_image != null)
                                <img src={{$comment->user->isAdmin() ?asset("assets/default/comment-admin.png") : asset("assets/users/" . $comment->user->user_image)}} alt="{{ $comment->name }}" class="fit fit-50">
                            @else
                                <img src={{asset("assets/default/comment.jpeg")}} alt="{{ $comment->name }}" class="fit fit-50">
                            @endif
                        </a>
                    </div>
                    <div class="content">
                        <p>
                            @if ($comment->user != null && $comment->user->isAdmin())
                                Admin
                            @elseif ($comment->user != null)
                                {{$comment->user->name}}
                            @else
                                {{$comment->name}}
                            @endif 
                            says:
                        </p>
                        <a href="{{ route('post.show', $comment->post->slug) }}">
                            {!! Illuminate\Support\Str::limit( $comment->comment, 25)  !!}
                        </a>
                    </div>
                </div>
            </li>
        @empty
            <li>No Comments Found!!</li>
        @endforelse
        </ul>
    </aside>
    <!-- End Single Widget -->
    <!-- Start Single Widget -->
    <aside class="widget category_widget">
        <h3 class="widget-title">Categories</h3>
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
                <li class="text-center"><a href="{{ route('categories') }}">Show all categories</a></li>
            @endif
        </ul>
    </aside>
    <!-- End Single Widget -->
    <!-- Start Single Widget -->
    <aside class="widget archives_widget">
        <h3 class="widget-title">Archives</h3>
        <ul>
            @forelse ($archives as $archive)
                <li><a href="{{ route('archive', ['year' => $archive->year, 'month' => $archive->month]) }}">{{ date('F Y', mktime(0, 0, 0, $archive->month, 1, $archive->year)) }}</a></li>
            @empty
                <li><a href="#">No posts Found!!</a></li>
            @endforelse
        </ul>
    </aside>
    <!-- End Single Widget -->
</div>