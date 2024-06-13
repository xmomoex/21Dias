@foreach($comments as $reply)
<div style="margin-left: 20px;">
    <p>{{ $reply->user->name }}: {{ $reply->comment }}</p>
    <div class="flex items-center mb-2">
        <form action="{{ route('comments.react', $reply->id) }}" method="POST" class="mr-2">
            @csrf
            <input type="hidden" name="type" value="like">
            <button type="submit" class="{{ $reply->reactions()->where('type', 'like')->where('user_id', Auth::id())->exists() ? 'text-blue-500' : 'text-gray-500' }} hover:text-blue-600">
                {{ $reply->reactions()->where('type', 'like')->where('user_id', Auth::id())->exists() ? 'Unlike' : 'Like' }}
            </button>
        </form>
        <p class="text-gray-500 ml-2">{{ $reply->reactions()->where('type', 'like')->count() }}</p>

        <form action="{{ route('comments.react', $reply->id) }}" method="POST" class="mr-2">
            @csrf
            <input type="hidden" name="type" value="dislike">
            <button type="submit" class="{{ $reply->reactions()->where('type', 'dislike')->where('user_id', Auth::id())->exists() ? 'text-red-500' : 'text-gray-500' }} hover:text-red-600">
                {{ $reply->reactions()->where('type', 'dislike')->where('user_id', Auth::id())->exists() ? 'Undislike' : 'Dislike' }}
            </button>
        </form>
        <p class="text-gray-500 ml-2">{{ $reply->reactions()->where('type', 'dislike')->count() }}</p>

        <!-- Delete button -->
        <form action="{{ route('comments.destroy', $reply->id) }}" method="POST" class="ml-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-600">Delete</button>
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