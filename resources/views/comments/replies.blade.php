@foreach($comments as $reply)
<div style="margin-left: 20px;">
    <p>{{ $reply->user->name }}: {{ $reply->comment }}</p>
    <div>
        <form action="{{ route('comments.react', $reply->id) }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="like">
            <button type="submit">Like</button>
        </form>
        <form action="{{ route('comments.react', $reply->id) }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="dislike">
            <button type="submit">Dislike</button>
        </form>
        <form action="{{ route('comments.removeReaction', $reply->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Remove Reaction</button>
        </form>
    </div>
    <div>
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="post_id" value="{{ $reply->post_id }}">
            <input type="hidden" name="parent_id" value="{{ $reply->id }}">
            <textarea name="comment" required></textarea>
            <button type="submit">Reply</button>
        </form>
    </div>
    @include('comments.replies', ['comments' => $reply->replies])
</div>
@endforeach