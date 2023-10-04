<ul class="comment__list">
@foreach ($comments as $comment)
    @if($comment->status != 0)
    <li>
        <div class="wn__comment @if(request()->input('comment') != null && request()->input('comment') == $comment->id) checked-comment @endif" id="comment-{{$comment->id}}" >
            <div class="thumb">
                <img src="{{asset('assets/default/comment.jpeg')}}" alt="comment images">
            </div>
            <div class="content">
                <div class="comnt__author d-block d-sm-flex">
                    @if ($postAuthorID == $comment->user_id)
                        <span><a href="#">{{$comment->user->name}}</a> <span class="text-success">Post author</span> </span>
                    @elseif ($comment->user_id != null)
                        <span>{{$comment->user->name}}</span>
                    @else
                        <span>{{$comment->name}}</span>
                    @endif
                    
                    <span>{{$comment->created_at->format('M j\, Y \a\t g\:i a')}}</span>
                    <div class="reply__btn">
                        <a href="javascript:void(0)" data-comment="{{ $comment->id }}">Reply</a>
                    </div>
                </div>
                <p>{{ $comment->comment }}</p>

                <div class="comment_respond replay-for-comment">                        
                    <form class="comment__form" action="{{route('comment.store', $post->slug)}}" method="GET">
                        
                        <input type="hidden" value="{{ $comment->id }}" name="comment_id" class="comment_id"/>
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
                            {{-- <div class="input__box website one--third">
                                <input name="comment_id" type="hidden" value="">                                    
                            </div> --}}
                        </div>
                        <div class="input__box">
                            <textarea class="shadow-2" name="comment" placeholder="Your comment here">{{old('comment')}}</textarea>
                            @error('comment')
                                <span class="error-input text-danger">{{$message}}</span>
                            @enderror
                        </div>                            
                        <div class="submite__btn">
                            
                            <input type="submit" value="Post Comment"/>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        @if($comment->replies->count() > 0)
            @include('frontend.partial.comments', ['comments' => $comment->replies, 'postAuthorID' => $postAuthorID])
        @endif
    </li>  
    @endif
@endforeach
</ul>
