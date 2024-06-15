<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <style>
        .form-container {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>

    <div class="w-100">
        <div class="">
            <div class="form-container">
                <h1 class="text-2xl font-bold mb-6">Create a new Post</h1>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Oops!</strong> Something went wrong.
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="body">Post</label>
                        <textarea id="body" name="body" class="form-control">{{ old('body') }}</textarea>
                    </div>
                    <!--<div class="form-group">
                        <label for="group_id">Group ID (Optional)</label>
                        <input type="text" id="group_id" name="group_id" class="form-control" value="{{ old('group_id') }}">
                    </div>-->
                    <div class="form-group">
                        <label for="file">Upload File (Optional)</label>
                        <input type="file" id="file" name="file" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="is_public">Privacy</label>
                        <select id="is_public" name="is_public" class="form-control">
                            <option value="1">Public</option>
                            <option value="0">Private</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="challenge_id">Select Challenge (Optional)</label>
                        <select id="challenge_id" name="challenge_id" class="form-control">
                            <option value="">Select Challenge</option>
                            @foreach($challenges as $challenge)
                            <option value="{{ $challenge->id }}">{{ $challenge->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Create Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>