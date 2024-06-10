<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white white:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 white:text-gray-100">
                    @if ($posts->isEmpty())
                    <p>No posts found.</p>
                    @else
                    <ul>
                        @foreach($posts as $post)
                        <li>
                            <p>{{ $post->body }}</p>
                            @if($post->file_path)
                            <p><img src="{{ asset('storage/' . $post->file_path) }}" alt="Post Image" style="max-width: 100%; height: auto;"></p>
                            @endif
                            <div>
                                <form action="{{ route('reactions.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <button type="submit" name="type" value="like">Like</button>
                                    <button type="submit" name="type" value="dislike">Dislike</button>
                                </form>
                            </div>
                            <div>
                                <p>Likes: {{ $post->reactions()->where('type', 'like')->count() }}</p>
                                <p>Dislikes: {{ $post->reactions()->where('type', 'dislike')->count() }}</p>
                            </div>
                            <div>
                                <h3>Comments</h3>
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <textarea name="comment" rows="2" required></textarea>
                                    <button type="submit">Add Comment</button>
                                </form>
                                @foreach($post->comments()->whereNull('parent_id')->get() as $comment)
                                <div>
                                    <p>{{ $comment->user->name }}: {{ $comment->comment }}</p>
                                    <div>
                                        <form action="{{ route('comments.react', $comment->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type" value="like">
                                            <button type="submit">Like</button>
                                        </form>
                                        <form action="{{ route('comments.react', $comment->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="type" value="dislike">
                                            <button type="submit">Dislike</button>
                                        </form>
                                        <form action="{{ route('comments.removeReaction', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Remove Reaction</button>
                                        </form>
                                    </div>
                                    <div>
                                        <form action="{{ route('comments.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <textarea name="comment" required></textarea>
                                            <button type="submit">Reply</button>
                                        </form>
                                    </div>
                                    @include('comments.replies', ['comments' => $comment->replies])
                                </div>
                                @endforeach
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif

                    @auth
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">Create New Post</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>