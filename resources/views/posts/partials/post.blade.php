<li class="bg-white dark:bg-gray-100 shadow-md rounded-lg p-4 mb-4" id="post-{{ $post->id }}">
    <div class="flex items-center mb-4">
        <img src="{{ $post->user->avatar_url() }}" alt="{{ $post->user->name }}'s Avatar" class="w-12 h-12 rounded-full mr-3">
        <div>
            <p class="font-bold">{{ $post->user->name }}</p>
            <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
        </div>
    </div>
    <p class="mb-4">{{ $post->body }}</p>
    @if($post->file_path)
    <p><img src="{{ asset('storage/' . $post->file_path) }}" alt="Post Image" class="max-w-full h-auto rounded-lg mb-4"></p>
    @endif
    <div class="flex items-center mb-4">
        <button data-post-id="{{ $post->id }}" data-type="like" class="like-button-{{ $post->id }} flex items-center text-blue-500 hover:text-blue-600 mr-2">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 9l-5 5m0 0l-5-5m5 5V3"></path>
            </svg>
            Like
        </button>
        <p id="like-count-{{ $post->id }}" class="text-gray-500 mr-2">{{ $post->reactions()->where('type', 'like')->count() }}</p>

        <button data-post-id="{{ $post->id }}" data-type="dislike" class="dislike-button-{{ $post->id }} flex items-center text-red-500 hover:text-red-600 mr-2">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l5-5m0 0l5 5m-5-5v12"></path>
            </svg>
            Dislike
        </button>
        <p id="dislike-count-{{ $post->id }}" class="text-gray-500">{{ $post->reactions()->where('type', 'dislike')->count() }}</p>
    </div>
    <div class="mb-4">
        <h3 class="font-bold text-lg mb-2">Comments ({{ $post->comments()->count() }})</h3>
        <button id="toggle-comments-btn-{{ $post->id }}" class="bg-blue-500 hover:bg-blue-600 text-black px-4 py-2 rounded-lg mb-2">Show Comments</button>
        <div id="comments-section-{{ $post->id }}" class="hidden">
            @foreach($post->comments()->whereNull('parent_id')->get() as $comment)
            <div class="mb-4 pl-4 border-l-2 border-gray-200">
                <p class="font-bold">{{ $comment->user->name }}:</p>
                <p class="mb-2">{{ $comment->comment }}</p>
                <div class="flex items-center mb-2">
                    <form action="{{ route('comments.react', $comment->id) }}" method="POST" class="mr-2">
                        @csrf
                        <input type="hidden" name="type" value="like">
                        <button type="submit" class="{{ $comment->reactions()->where('type', 'like')->where('user_id', Auth::id())->exists() ? 'text-blue-500' : 'text-gray-500' }} hover:text-blue-600">
                            {{ $comment->reactions()->where('type', 'like')->where('user_id', Auth::id())->exists() ? 'Unlike' : 'Like' }}
                        </button>
                    </form>
                    <p class="text-gray-500 ml-2">{{ $comment->reactions()->where('type', 'like')->count() }}</p>

                    <form action="{{ route('comments.react', $comment->id) }}" method="POST" class="mr-2">
                        @csrf
                        <input type="hidden" name="type" value="dislike">
                        <button type="submit" class="{{ $comment->reactions()->where('type', 'dislike')->where('user_id', Auth::id())->exists() ? 'text-red-500' : 'text-gray-500' }} hover:text-red-600">
                            {{ $comment->reactions()->where('type', 'dislike')->where('user_id', Auth::id())->exists() ? 'Undislike' : 'Dislike' }}
                        </button>
                    </form>
                    <p class="text-gray-500 ml-2">{{ $comment->reactions()->where('type', 'dislike')->count() }}</p>
                </div>
                <div class="ml-4">
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <textarea name="comment" required class="w-full p-2 border rounded-lg mb-2"></textarea>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-black px-4 py-2 rounded-lg">Reply</button>
                    </form>
                </div>
                @include('comments.replies', ['comments' => $comment->replies])

                <!-- Add Delete Button for the Comment -->
                @auth
                @if(Auth::id() == $comment->user_id)
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-red px-4 py-2 rounded-lg">Delete Comment</button>
                </form>
                @endif
                @endauth
            </div>
            @endforeach
        </div>
        <form action="{{ route('comments.store') }}" method="POST" id="comment-form-{{ $post->id }}" class="hidden">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <textarea name="comment" rows="2" required class="w-full p-2 border rounded-lg mb-2"></textarea>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-red px-4 py-2 rounded-lg">Add Comment</button>
        </form>
    </div>
    @if($post->challenge)
    <div class="mt-4">
        <p>Challenge: <a href="{{ route('challenges.show', $post->challenge->id) }}" class="text-blue-500 hover:underline">{{ $post->challenge->name }}</a></p>
    </div>
    @endif
    @auth
    @if(Auth::id() == $post->user_id)
    <button data-post-id="{{ $post->id }}" class="delete-post-{{ $post->id }} bg-red-500 hover:bg-red-600 text-red px-4 py-2 rounded-lg mt-4">Delete Post</button>
    @endif
    @endauth
</li>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const postId = "{{ $post->id }}";
        const toggleBtn = document.getElementById('toggle-comments-btn-' + postId);
        const commentsSection = document.getElementById('comments-section-' + postId);
        const commentForm = document.getElementById('comment-form-' + postId);

        toggleBtn.addEventListener('click', function() {
            if (commentsSection.classList.contains('hidden')) {
                commentsSection.classList.remove('hidden');
                commentForm.classList.remove('hidden');
                toggleBtn.textContent = 'Hide Comments';
            } else {
                commentsSection.classList.add('hidden');
                commentForm.classList.add('hidden');
                toggleBtn.textContent = 'Show Comments';
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
                        alert(data.message);
                        // Eliminar el post del DOM
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
    });
</script>