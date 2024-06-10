<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Follow Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($requests->isEmpty())
                    <p>No follow requests found.</p>
                    @else
                    <ul>
                        @foreach($requests as $request)
                        <li>
                            <p>{{ $request->follower->name }}</p>
                            <form action="{{ route('follow_requests.accept', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Accept</button>
                            </form>
                            <form action="{{ route('follow_requests.decline', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Decline</button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>