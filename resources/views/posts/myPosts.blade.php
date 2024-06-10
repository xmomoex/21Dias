<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>