<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Challenges') }}
        </h2>
    </x-slot>

    <style>
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            margin-bottom: 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .challenge-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .challenge-list li {
            margin-bottom: 10px;
        }

        .challenge-list a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            background-color: #fff;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: all 0.3s;
        }

        .challenge-list a:hover {
            background-color: #e0f7fa;
            border-color: #00acc1;
            color: #00796b;
        }
    </style>

    <div class="container w-100">
        <a href="{{ route('challenges.create') }}" class="btn-primary">Crear Nuevo Challenge</a>
        <ul class="challenge-list">
            @foreach($challenges as $challenge)
            <li>
                <a href="{{ route('challenges.posts', $challenge->id) }}">{{ $challenge->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>