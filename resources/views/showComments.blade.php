@foreach($comments as $comment)
    <div class="display-comments"  @if($comment->parent_id) style="margin-left: 50px" @endif>
        {{ $comment->user->name ?? 'Anonim'}}
        <p>Comment: {{ $comment->massage }}</p>
        <a href="" id="reply"></a>
        <form method="post" action="{{ route('comments.store') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="massage" class="form-control" required/>
                <input type="hidden" name="post_id" value="{{ $post_id }}" />
                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group">
                <input type="submit" value="Reply" />
            </div>
        </form>
        @include('showComments', ['comments' => $comment->replies])
    </div>
@endforeach
