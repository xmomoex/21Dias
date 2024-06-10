<!DOCTYPE html>
<html>

<head>
    <title>My Posts</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container">
        <h1>My Posts</h1>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($posts->isEmpty())
        <p>You have no posts.</p>
        @else
        <ul>
            @foreach($posts as $post)
            <li>
                <p>{{ $post->body }}</p>
                @if($post->file_path)
                <p><img src="{{ asset('storage/' . $post->file_path) }}" alt="Post Image" style="max-width: 100%; height: auto;"></p>
                @endif
            </li>
            @endforeach
        </ul>
        @endif

        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create New Post</a>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>