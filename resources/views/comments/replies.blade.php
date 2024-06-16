<style>
    .reaction-btn {
        display: flex;
        align-items: center;
        border: none;
        background: none;
        cursor: pointer;
    }

    .reaction-btn i {
        margin-right: 0.5rem;
    }

    .reply-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border: none;
        background-color: #3490dc;
        color: #ffffff;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
        font-weight: bold;
    }

    .reply-btn i {
        margin-right: 0.5rem;
    }

    .reply-btn:hover {
        background-color: #2779bd;
    }

    .reply-form {
        margin-top: 0.5rem;
        display: none;
        /* Initially hidden */
    }

    .reply-form textarea {
        width: calc(100% - 4rem);
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 0.25rem;
        resize: vertical;
        font-size: 14px;
    }

    .reply-form button {
        margin-left: 0.5rem;
        padding: 0.5rem 1rem;
        background-color: #4caf50;
        color: #ffffff;
        border: none;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-weight: bold;
    }

    .reply-form button:hover {
        background-color: #45a049;
    }

    .reply-comment-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border: none;
        background-color: #3490dc;
        color: #ffffff;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
        font-weight: bold;
    }

    .reply-comment-btn:hover {
        background-color: #2779bd;
    }
</style>
</head>

<body>
    @foreach($comments as $reply)
    <div style="margin-left: 20px;">
        <p>{{ $reply->user->name }}: {{ $reply->comment }}</p>
        <div class="flex items-center mb-2">
            <form action="{{ route('comments.react', $reply->id) }}" method="POST" class="mr-2">
                @csrf
                <input type="hidden" name="type" value="like">
                <button type="submit" class="reaction-btn {{ $reply->reactions()->where('type', 'like')->where('user_id', Auth::id())->exists() ? 'text-blue-500' : 'text-gray-500' }} hover:text-blue-600">
                    <i class="far fa-thumbs-up"></i>
                    <span>{{ $reply->reactions()->where('type', 'like')->count() }}</span>
                </button>
            </form>

            <form action="{{ route('comments.react', $reply->id) }}" method="POST" class="mr-2 ms-4">
                @csrf
                <input type="hidden" name="type" value="dislike">
                <button type="submit" class="reaction-btn {{ $reply->reactions()->where('type', 'dislike')->where('user_id', Auth::id())->exists() ? 'text-red-500' : 'text-gray-500' }} hover:text-red-600">
                    <i class="far fa-thumbs-down"></i>
                    <span>{{ $reply->reactions()->where('type', 'dislike')->count() }}</span>
                </button>
            </form>

            <!-- Delete button -->
            <form action="{{ route('comments.destroy', $reply->id) }}" method="POST" class="ml-2 ms-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-600">
                    <i class="far fa-trash-alt"></i>
                </button>
            </form>

            <button class="ms-4 reply-comment-btn" onclick="toggleReplyForm({{ $reply->id }})">
                <i class="fas fa-reply"></i>
            </button>
        </div>
        <div id="reply-form-{{ $reply->id }}" class="reply-form">
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $reply->post_id }}">
                <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                <textarea name="comment" placeholder="Reply to {{ $reply->user->name }}" required></textarea>
                <button type="submit" class="reply-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>

        @include('comments.replies', ['comments' => $reply->replies])
    </div>
    @endforeach

    <script>
        function toggleReplyForm(commentId) {
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        }
    </script>