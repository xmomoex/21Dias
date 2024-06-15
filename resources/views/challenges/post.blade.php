<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $challenge->name }} Posts
        </h2>
    </x-slot>

    <div class="w-100">
        <ul>
            @foreach($posts as $post)
            @include('posts.partials.post', ['post' => $post])
            @endforeach
        </ul>
    </div>
</x-app-layout>