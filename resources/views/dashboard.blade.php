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
                        @include('posts.partials.post', ['post' => $post])
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