<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Privacy') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your profile privacy settings.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.updatePrivacy') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="flex items-center">
            <label for="is_public" class="mr-4">{{ __('Make profile public') }}</label>
            <input type="hidden" name="is_public" value="0">
            <input type="checkbox" name="is_public" id="is_public" value="1" {{ Auth::user()->is_public ? 'checked' : '' }}>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-privacy-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>