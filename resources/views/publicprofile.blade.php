<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->name }}'s Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="profile-header">
                        <img src="{{ asset('storage/' . $user->cover_path) }}" alt="Cover Photo" class="cover-photo">
                        <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="Avatar" class="avatar">
                        <h1>{{ $user->name }}</h1>
                        <p>{{ '@' . $user->username }}</p>
                    </div>
                    <div class="profile-stats">
                        <p>Followers: {{ $followersCount }}</p>
                        <p>Following: {{ $followingCount }}</p>
                        <p>Total Likes: {{ $likesCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>