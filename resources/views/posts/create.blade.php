<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1>Create a new Post</h1>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea id="body" name="body" class="form-control">{{ old('body') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="group_id">Group ID (Optional)</label>
                            <input type="text" id="group_id" name="group_id" class="form-control" value="{{ old('group_id') }}">
                        </div>
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
                            <button type="submit" class="btn btn-primary">Create Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>