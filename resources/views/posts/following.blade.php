<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts from Following') }}
        </h2>
    </x-slot>
    <div class="w-100">
        @if ($posts->isEmpty())
        <p>No posts found from users you are following.</p>
        @else
        <ul>
            @foreach($posts as $post)
            @include('posts.partials.post', ['post' => $post])
            @endforeach
        </ul>
        @endif
    </div>
</x-app-layout>