<style>
    .profile-show {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #e2e8f0;
        transition: background-color 0.2s ease;
    }

    .profile-show:hover {
        background-color: #f7fafc;
    }

    .profile-show-avatar img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-show h3 {
        margin: 0;
    }

    .profile-show form,
    .profile-show button {
        margin-left: auto;
    }

    .profile-show button,
    .profile-show form button {
        background-color: #38a169;
        /* Default green */
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .profile-show button:hover,
    .profile-show form button:hover {
        background-color: #2f855a;
        /* Darker green on hover */
    }

    .profile-show button.text-red-500,
    .profile-show form button.text-red-500 {
        background-color: #e53e3e;
        /* Red color for unfollow */
    }

    .profile-show button.text-red-500:hover,
    .profile-show form button.text-red-500:hover {
        background-color: #c53030;
        /* Darker red on hover */
    }

    .profile-show button.text-yellow-500 {
        background-color: #d69e2e;
        /* Yellow color for pending */
        cursor: default;
    }
</style>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="w-100">
        @if ($users->isEmpty())
        <p>No users found.</p>
        @else
        <ul>
            @foreach ($users as $user)
            <a class="w-100" href="{{ route('publicprofile.show', $user->id) }}" class="flex items-center p-4 hover:bg-gray-100 transition-colors duration-200">
                <li class="profile-show">

                    <div class="profile-show-avatar">
                        <img src="{{ $user->avatar_path ? asset('storage/' . $user->avatar_path) : asset('images/default-avatar.png') }}" alt="Avatar" class="avatar w-10 h-10 rounded-full">
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold">{{ $user->name }}</h3>
                        <!--<p class="text-gray-600">{{ '@' . $user->username }}</p>-->
                    </div>
                    <div class="ml-auto flex items-center">
                        <div class="flex items-center">
                            @if (Auth::user()->following->contains($user->id))
                            <form action="{{ route('users.unfollow', $user->id) }}" method="POST" class="inline-block ml-4">
                                @csrf
                                <button type="submit" class="text-red-500 hover:underline">Siguiendo</button>
                            </form>
                            @elseif ($followRequests->contains('user_id', $user->id))
                            <button class="text-yellow-500 ml-4">Pendiente</button>
                            @else
                            <form action="{{ route('users.follow', $user->id) }}" method="POST" class="inline-block ml-4">
                                @csrf
                                <button type="submit" class="text-green-500 hover:underline">Seguir</button>
                            </form>
                            @endif
                        </div>
                    </div>

                </li>
            </a>
            @endforeach
        </ul>
        @endif
    </div>

</x-app-layout>