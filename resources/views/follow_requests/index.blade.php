<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Follow Requests') }}
        </h2>
    </x-slot>

    <style>
        .requests-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .requests-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .requests-list li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 15px;
            background-color: #fff;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            transition: all 0.3s;
        }

        .requests-list li:hover {
            background-color: #e0f7fa;
            border-color: #00acc1;
        }

        .requests-list p {
            margin: 0;
            font-size: 1rem;
            color: #333;
        }

        .request-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>

    <div class="requests-container w-100">
        @if ($requests->isEmpty())
        <p>No follow requests found.</p>
        @else
        <ul class="requests-list">
            @foreach($requests as $request)
            <li>
                <p>{{ $request->follower->name }}</p>
                <div class="request-actions">
                    <form action="{{ route('follow_requests.accept', $request->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Accept</button>
                    </form>
                    <form action="{{ route('follow_requests.decline', $request->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Decline</button>
                    </form>
                </div>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
</x-app-layout>