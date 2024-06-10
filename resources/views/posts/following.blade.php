<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts from Following') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($posts->isEmpty())
                    <p>No posts found from users you are following.</p>
                    @else
                    <ul>
                        @foreach($posts as $post)
                        <li class="mb-4">
                            <div class="flex items-center">
                                <img src="{{ $post->user->avatar_path ? asset('storage/' . $post->user->avatar_path) : asset('images/default-avatar.png') }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full mr-4">
                                <div>
                                    <p class="font-semibold">{{ $post->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                    <p>{{ $post->body }}</p>
                                    @if($post->file_path)
                                    <img src="{{ asset('storage/' . $post->file_path) }}" alt="Post Image" style="max-width: 100%; height: auto;">
                                    @endif
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>