<style>
    .comment-button {
        background: #0095f6;
        border-radius: 5px;
        color: white;
        padding: 5px 10px;
    }

    .comments-section {
        margin-top: 15px;
    }

    .comment {
        border-left: 2px solid #efefef;
        padding-left: 15px;
        margin-bottom: 10px;
    }

    .comment-author {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .comment-text {
        margin-bottom: 5px;
    }

    .comment-actions {
        align-items: center;
        display: flex;
    }

    .comment-action-form {
        margin-right: 10px;
    }

    .reply-form-container {
        margin-top: 10px;
    }

    .reply-button {
        background: #0095f6;
        border-radius: 5px;
        color: white;
        padding: 5px 10px;
    }

    .comment-form textarea,
    .reply-form-container textarea {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
        padding: 10px;
        width: 100%;
    }

    .submit-comment-button {
        background: #0095f6;
        border-radius: 5px;
        color: white;
        padding: 5px 10px;
    }

    .post-challenge {
        margin-top: 10px;
    }

    .delete-button,
    .delete-post-button {
        background: none;
        border: none;
        color: red;
        cursor: pointer;
        font-size: 20px;
    }
</style>


<li class="post bg-white dark:bg-gray-100 shadow-md rounded-lg p-4 mb-4" id="post-{{ $post->id }}">
    <a class="w-100" href="{{ route('publicprofile.show', $post->user) }}" class="flex items-center p-4 hover:bg-gray-100 transition-colors duration-200">
        <div class="top">
            <img src="{{ $post->user->avatar_path ? asset('storage/' . $post->user->avatar_path) : asset('images/default-avatar.png') }}" alt="Avatar" class="w-12 h-12 rounded-full mr-3">

            <div class="ms-4">
                <p class="nombre font-bold">{{ $post->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                @if ($post->is_public==0)
                <i class="fa-solid fa-lock text-gray-500 text-sm ms-1" title="Post privado"></i>
                @endif
            </div>
        </div>
    </a>
    <p class="mb-4">{{ $post->body }}</p>
    @if($post->file_path)
    <p class="imagen-bg"><img src="{{ asset('storage/' . $post->file_path) }}" alt="Post Image" class="imagen max-w-full h-auto rounded-lg mb-4"></p>
    @endif
    <div class="flex items-center mb-4">
        <button data-post-id="{{ $post->id }}" data-type="like" class="like-button-{{ $post->id }} flex items-center text-blue-500 hover:text-blue-600 mr-2">
            <i class="fa-regular fa-thumbs-up"></i>
        </button>

        <p id="like-count-{{ $post->id }}" class="text-gray-500 mr-2">{{ $post->reactions()->where('type', 'like')->count() }}</p>

        <button data-post-id="{{ $post->id }}" data-type="dislike" class="ms-4 dislike-button-{{ $post->id }} flex items-center text-red-500 hover:text-red-600 mr-2">
            <i class="fa-regular fa-thumbs-down"></i>
        </button>
        <p id="dislike-count-{{ $post->id }}" class="text-gray-500">{{ $post->reactions()->where('type', 'dislike')->count() }}</p>

        <button id="toggle-comments-btn-{{ $post->id }}" class="bg-blue-500 hover:bg-blue-600 text-black px-4 py-2 rounded-lg mb-2"><i class="fa-regular fa-comment"></i>({{ $post->comments()->count() }})</button>
    </div>
    <div class="comments-section hidden" id="comments-section-{{ $post->id }}">
        @foreach($post->comments()->whereNull('parent_id')->get() as $comment)
        <div class="comment">
            <p class="comment-author">{{ $comment->user->name }}:</p>
            <p class="comment-text">{{ $comment->comment }}</p>
            <div class="comment-actions">
                <form action="{{ route('comments.react', $comment->id) }}" method="POST" class="comment-action-form">
                    @csrf
                    <input type="hidden" name="type" value="like">
                    <button type="submit" class="action-button {{ $comment->reactions()->where('type', 'like')->where('user_id', Auth::id())->exists() ? 'text-blue-500' : 'text-gray-500' }} hover:text-blue-600">
                        <i class="fa{{ $comment->reactions()->where('type', 'like')->where('user_id', Auth::id())->exists() ? 's' : 'r' }} fa-thumbs-up"></i>
                    </button>
                </form>
                <p class="action-count">{{ $comment->reactions()->where('type', 'like')->count() }}</p>
                <form action="{{ route('comments.react', $comment->id) }}" method="POST" class="ms-4 comment-action-form">
                    @csrf
                    <input type="hidden" name="type" value="dislike">
                    <button type="submit" class="action-button {{ $comment->reactions()->where('type', 'dislike')->where('user_id', Auth::id())->exists() ? 'text-red-500' : 'text-gray-500' }} hover:text-red-600">
                        <i class="fa{{ $comment->reactions()->where('type', 'dislike')->where('user_id', Auth::id())->exists() ? 's' : 'r' }} fa-thumbs-down"></i>
                    </button>
                </form>
                <p class="action-count">{{ $comment->reactions()->where('type', 'dislike')->count() }}</p>
                @auth
                @if(Auth::id() == $comment->user_id)
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="comment-action-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-button delete-button"><i class="fa-solid fa-trash"></i></button>
                </form>
                @endif
                @endauth
                <button onclick="toggleReplyForm({{ $comment->id }})" class="reply-button"><i class="fas fa-reply"></i></button>
            </div>
            <div class="reply-form-container hidden" id="reply-form-{{ $comment->id }}">
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <textarea name="comment" placeholder="Reply to {{ $comment->user->name }}" required></textarea>
                    <button type="submit" class="reply-button"><i class="fa-regular fa-paper-plane"></i></button>
                </form>
            </div>
            @include('comments.replies', ['comments' => $comment->replies])
        </div>
        @endforeach
    </div>
    <form action="{{ route('comments.store') }}" method="POST" id="comment-form-{{ $post->id }}" class="comment-form hidden">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <textarea name="comment" rows="2" required></textarea>
        <button type="submit" class="submit-comment-button"><i class="fa-regular fa-paper-plane"></i></button>
    </form>
    @if($post->challenge)
    <div class="post-challenge">
        <p>Challenge: <a href="{{ route('challenges.show', $post->challenge->id) }}">{{ $post->challenge->name }}</a></p>
    </div>
    @endif
    @auth
    @if(Auth::id() == $post->user_id)
    <button data-post-id="{{ $post->id }}" class="delete-post-{{ $post->id }}"><i class="fa-solid fa-trash"></i></button>
    @endif
    @endauth
</li>

<script>
    function toggleReplyForm(commentId) {
        var replyForm = document.getElementById('reply-form-' + commentId);
        replyForm.style.display = replyForm.style.display === 'none' || replyForm.style.display === '' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const postId = "{{ $post->id }}";
        const toggleBtn = document.getElementById('toggle-comments-btn-' + postId);
        const commentsSection = document.getElementById('comments-section-' + postId);
        const commentForm = document.getElementById('comment-form-' + postId);

        toggleBtn.addEventListener('click', function() {
            if (commentsSection.classList.contains('hidden')) {
                commentsSection.classList.remove('hidden');
                commentForm.classList.remove('hidden');

            } else {
                commentsSection.classList.add('hidden');
                commentForm.classList.add('hidden');

            }
        });

        // Modificar los selectores para las clases específicas de like y dislike
        const likeButton = document.querySelector('.like-button-' + postId);
        const dislikeButton = document.querySelector('.dislike-button-' + postId);

        likeButton.addEventListener('click', function(event) {
            event.preventDefault();
            const postId = this.getAttribute('data-post-id');
            const type = this.getAttribute('data-type');

            fetch('{{ route("reactions.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        post_id: postId,
                        type: type
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`like-count-${postId}`).textContent = data.likeCount;
                        document.getElementById(`dislike-count-${postId}`).textContent = data.dislikeCount;

                        // Actualizar el estado de los botones
                        if (likeButton.querySelector('i').classList === 'fa-regular fa-thumbs-up') {
                            // Cambiar icono de like<i class="fa-solid fa-thumbs-up"></i>

                            likeButton.querySelector('i').classList.remove('fa-regular');
                            likeButton.querySelector('i').classList.add('fa-solid');
                            likeButton.classList.add('text-blue-700');
                        } else {


                            // Cambiar icono de like si estaba activo
                            likeButton.querySelector('i').classList.remove('fa-solid');
                            likeButton.querySelector('i').classList.add('fa-regular');
                            likeButton.classList.remove('text-blue-700');
                        }
                    } else {
                        console.error('Error updating reaction');
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        dislikeButton.addEventListener('click', function(event) {
            event.preventDefault();
            const postId = this.getAttribute('data-post-id');
            const type = this.getAttribute('data-type');

            fetch('{{ route("reactions.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        post_id: postId,
                        type: type
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`like-count-${postId}`).textContent = data.likeCount;
                        document.getElementById(`dislike-count-${postId}`).textContent = data.dislikeCount;

                        // Actualizar el estado de los botones
                        if (type === 'like') {
                            likeButton.classList.add('text-blue-700');
                            dislikeButton.classList.remove('text-red-700');
                        } else if (type === 'dislike') {
                            dislikeButton.classList.add('text-red-700');
                            likeButton.classList.remove('text-blue-700');
                        }
                    } else {
                        console.error('Error updating reaction');
                    }
                })
                .catch(error => console.error('Error:', error));
        });



        const deleteButton = document.querySelector('.delete-post-' + postId);


        if (deleteButton) {
            deleteButton.addEventListener('click', function() {
                const postId = deleteButton.getAttribute('data-post-id');
                // Mostrar mensaje de confirmación
                const confirmDelete = confirm('¿Estás seguro de que quieres eliminar este post?');
                if (!confirmDelete) {
                    return; // Si el usuario cancela, no se realiza la eliminación
                }

                fetch(`/posts/${postId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {

                            const postElement = document.getElementById(`post-${postId}`);
                            if (postElement) {
                                postElement.remove();
                            }
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        alert('An error occurred while deleting the post.');
                        console.error('Error:', error);
                    });
            });
        }
    });
</script>