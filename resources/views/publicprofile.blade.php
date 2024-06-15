<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->name }}'s Profile
        </h2>
    </x-slot>
    <div class="profile-card">
        <div class="profile-header">
            <!--<img src="{{ asset('storage/' . $user->cover_path) }}" alt="Cover Photo" class="cover-photo">-->
            <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="Avatar" class="avatar">
        </div>
        <div class="profile-info">
            <h1>{{ $user->name }}</h1>
            <h2>{{ '@' . $user->username }}</h2>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Architecto error quae nostrum deserunt modi nihil, commodi debitis voluptates cum fugiat accusantium explicabo. Numquam nemo delectus blanditiis tempora error, placeat minima?</p>
        </div>
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
</x-app-layout>