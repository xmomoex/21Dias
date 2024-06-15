<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <style>
        .following-container {
            max-width: 600px;
            margin: auto;
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .following-container h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .following-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .following-list li {
            margin-bottom: 10px;
        }

        .following-list a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            background-color: #fff;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: all 0.3s;
        }

        .following-list a:hover {
            background-color: #e0f7fa;
            border-color: #00acc1;
            color: #00796b;
        }
    </style>
    <div class="following-container w-100">
        <h3>Your Following</h3>
        <ul class="following-list">
            @foreach($following as $user)
            <li>
                <a href="{{ route('messages.chat', $user->id) }}">{{ $user->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>