<ul>
    @forelse ($comments as $comment)
    <li class="comment @if(request()->input('comment') != null && request()->input('comment') == $comment->id) checked-comment @endif"  id="{{$comment->id}}">
        <div class="comment-options">
            <span>
                @if($comment->user_id == null)
                    {{$comment->name}}                
                @else
                    <a href="{{route('admin.post.all',['user' => $comment->user->id])}}">
                        {{$comment->user->name}}
                        @if( $comment->user->isAdmin())
                            (Admin)
                        @endif
                    </a>
                @endif 

                @if($comment->user_id == $post->user->id)
                    <strong>(Post Author)</strong>
                @endif 
            </span>

            @if($comment->status == 0)
                <span class="text-danger"><strong>Inactive</strong></span>
                <div class="hidden-options">
                    <a href="{{ route('admin.comment.status', [$comment->id, 'approve']) }}" class="btn btn-secondary py-0 px-1">Approve</a>
            @else
                <span class="text-success"><strong>Active</strong></span>
                <div class="hidden-options">
                    <a href="{{ route('admin.comment.status', [$comment->id, 'disapprove']) }}" class="btn btn-warning py-0 px-1">Disapprove</a>
            @endif  
            
                    @can('delete comment')
                        <a href="javascript:void(0)" class="btn btn-danger  py-0 px-1"
                        onclick="if (confirm('Are you sure to delete this comment?') ) { document.getElementById('comment-delete-{{ $comment->id }}').submit(); } else { return false; }">
                            Delete    
                        </a>
                        <form action="{{ route('admin.comment.destroy', $comment->id) }}" method="post" id="comment-delete-{{ $comment->id }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endcan 

                    @can('store comment')
                        <a href="#replay" class="btn btn-info  py-0 px-1 add-replay" data-comment="{{$comment->id}}">replay</a>
                    @endcan
                </div> <!-- end hidden-options -->
        </div>
        <div class="comment-comment">
            {{$comment->comment}}
        </div>
        <div class="add-replay-form  @if(old('comment_id') == $comment->id) show @endif">
            @can('store comment')
                <form action="{{route('admin.comment.store')}}" method="post" class="px-3">
                    @csrf
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <input type="hidden" name="comment_id" value="{{$comment->id}}" id="">
                    <div class="form-group">
                        <textarea  name="comment" cols="30" rows="3" placeholder="Add comment" class="form-control  @if(old('comment_id') == $comment->id) @error('comment') is-invalid @enderror @endif"></textarea>
                        @if(old('comment_id') == $comment->id)
                            @error('comment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                            @enderror
                            @error('post_id')
                                <span class="text-danger d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                            @enderror
                        @endif
                    </div>
                    <input type="submit" value="Add comment" class="btn btn-primary mb-3">
                </form>
                @endcan
        </div>
    </li>
        @if($comment->replies->count() > 0)
            @include('backend.posts.post-comments', ['comments' => $comment->adminReplies])
        @endif        
    @empty
    
    @endforelse
</ul>