<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($users->isEmpty())
                    <p>No users found.</p>
                    @else
                    <ul>
                        @foreach ($users as $user)
                        <li class="mb-4">
                            <div class="flex items-center">
                                <img src="{{ $user->avatar_path ? asset('storage/' . $user->avatar_path) : asset('default-avatar.png') }}" alt="Avatar" class="w-10 h-10 rounded-full">
                                <div class="ml-4">
                                    <h3 class="font-semibold">{{ $user->name }}</h3>
                                    <p class="text-gray-600">{{ '@' . $user->username }}</p>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('publicprofile.show', $user->id) }}" class="text-blue-500 hover:underline">View Profile</a>
                                @if (Auth::user()->following->contains($user->id))
                                <form action="{{ route('users.unfollow', $user->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:underline ml-4">Unfollow</button>
                                </form>
                                @else
                                <form action="{{ route('users.follow', $user->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-green-500 hover:underline ml-4">Follow</button>
                                </form>
                                @endif
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