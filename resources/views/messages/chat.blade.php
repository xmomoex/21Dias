<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chat with ') . $user->name }}
        </h2>
    </x-slot>

    <style>
        .chat-container {
            max-width: 600px;
            margin: auto;
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .message-container {
            display: flex;
            margin-bottom: 10px;
        }

        .message-container.sent {
            justify-content: flex-end;
        }

        .message-container.received {
            justify-content: flex-start;
        }

        .message-bubble {
            padding: 10px 15px;
            border-radius: 20px;
            max-width: 80%;
            display: inline-block;
        }

        .message-bubble.sent {
            background-color: #dcf8c6;
            text-align: right;
        }

        .message-bubble.received {
            background-color: #fff;
            border: 1px solid #ccc;
        }

        .form-control {
            width: calc(100% - 50px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        .btn-primary {
            background-color: #25d366;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }

        .btn-primary:hover {
            background-color: #128c7e;
        }

        .chat-form {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .bg-chat {
            background-color: grey;
            border-radius: 10px;
        }
    </style>
    <div class="p-6 w-100 bg-chat">
        <div class="chat-container">
            @foreach($messages as $message)
            <div class="message-container {{ $message->sender_id === Auth::id() ? 'sent' : 'received' }}">
                <div class="message-bubble {{ $message->sender_id === Auth::id() ? 'sent' : 'received' }}">
                    <p><strong>{{ $message->sender->name }}:</strong> {{ $message->message }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <form action="{{ route('messages.store') }}" method="POST" class="chat-form">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
            <textarea name="message" rows="1" class="form-control" placeholder="Escribe un mensaje" required></textarea>
            <button type="submit" class="btn-primary">
                <i class="fa fa-paper-plane"></i>
            </button>
        </form>
    </div>
</x-app-layout>