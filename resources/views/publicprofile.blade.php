<style>
    /* Specific styles for follow/unfollow/pending buttons */
    .follow-unfollow-btn {
        background-color: #38a169;
        /* Default green */
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        text-align: center;
        margin-top: 10px;
        /* Optional: Add some margin */
    }

    .follow-unfollow-btn:hover {
        background-color: #2f855a;
        /* Darker green on hover */
    }

    .follow-unfollow-btn.text-red-500 {
        background-color: #e53e3e;
        /* Red color for unfollow */
    }

    .follow-unfollow-btn.text-red-500:hover {
        background-color: #c53030;
        /* Darker red on hover */
    }

    .follow-unfollow-btn.text-yellow-500 {
        background-color: #d69e2e;
        /* Yellow color for pending */
        cursor: default;
    }

    .follow-unfollow-btn[disabled] {
        background-color: #d69e2e;
        /* Yellow color for pending */
        cursor: not-allowed;
        /* Add not-allowed cursor for disabled buttons */
    }

    /* Optional: Additional styling for better appearance */
    .follow-unfollow-btn.ml-4 {
        margin-left: 1rem;
        /* Adjust margin as needed */
    }
</style>



<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->name }}'s Profile
        </h2>
    </x-slot>
    <div class="profile-card">
        <div class="profile-header">
            <!--<img src="{{ asset('storage/' . $user->cover_path) }}" alt="Cover Photo" class="cover-photo">-->
            <img src="{{ $user->avatar_path ? asset('storage/' . $user->avatar_path) : asset('images/default-avatar.png') }}" alt="Avatar" class="avatar">
        </div>
        <div class="profile-info">
            <h1>{{ $user->name }}</h1>
            <!--<h2>{{ '@' . $user->username }}</h2>-->
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Architecto error quae nostrum deserunt modi nihil, commodi debitis voluptates cum fugiat accusantium explicabo. Numquam nemo delectus blanditiis tempora error, placeat minima?</p>
        </div>
        @if (!$isOwnProfile)
        @if ($isFollowing)
        <form action="{{ route('users.unfollow', $user->id) }}" method="POST" class="inline-block">
            @csrf
            <button type="submit" class="follow-unfollow-btn text-red-500 hover:underline ml-4">Unfollow</button>
        </form>
        @else
        @php
        $followRequest = \App\Models\FollowRequest::where('user_id', $user->id)
        ->where('follower_id', Auth::id())
        ->first();
        @endphp

        @if ($followRequest)
        <button type="button" class="follow-unfollow-btn text-yellow-500 ml-4" disabled>Pending</button>
        @else
        <form action="{{ route('users.follow', $user->id) }}" method="POST" class="inline-block">
            @csrf
            <button type="submit" class="follow-unfollow-btn text-green-500 hover:underline ml-4">Follow</button>
        </form>
        @endif
        @endif
        @endif

        <div class="profile-stats">
            <div class="stats">
                <p>Followers:</p>
                <p>{{ $followersCount }}</p>
            </div>
            <div class="stats">
                <p>Following:</p>
                <p>{{ $followingCount }}</p>
            </div>
            <div class="stats">
                <p>Likes:</p>
                <p>{{ $likesCount }}</p>
            </div>
        </div>
    </div>

    <div class="w-100">
        @if ($posts->isEmpty())
        <p>No posts found.</p>
        @else
        <ul>
            @foreach($posts as $post)
            @include('posts.partials.post', ['post' => $post])
            @endforeach
        </ul>
        @endif
    </div>
</x-app-layout>