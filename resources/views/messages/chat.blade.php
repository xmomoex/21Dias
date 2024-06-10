<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat with ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        @foreach($messages as $message)
                        <div class="{{ $message->sender_id === Auth::id() ? 'text-right' : '' }}">
                            <p><strong>{{ $message->sender->name }}:</strong> {{ $message->message }}</p>
                        </div>
                        @endforeach
                    </div>

                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                        <div class="mt-4">
                            <textarea name="message" rows="3" class="form-control w-full" required></textarea>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>