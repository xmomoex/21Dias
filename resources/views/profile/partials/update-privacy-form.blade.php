<style>
    .section-container {
        background-color: #ffffff;
        padding: 32px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        margin: 0 auto;
    }

    .section-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2D3748;
        margin-bottom: 8px;
    }

    .section-header p {
        font-size: 0.875rem;
        color: #718096;
    }

    .form-container {
        margin-top: 24px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .form-checkbox {
        display: flex;
        align-items: center;
    }

    .form-checkbox label {
        margin-right: 16px;
        font-size: 1rem;
        color: #2D3748;
    }

    .form-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .save-button {
        background-color: #3182CE;
        color: white;
        padding: 12px 24px;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .save-button:hover {
        background-color: #2B6CB0;
    }

    .status-message {
        font-size: 0.875rem;
        color: #718096;
    }
</style>

<section class="section-container">
    <header class="section-header">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Privacy') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your profile privacy settings.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.updatePrivacy') }}" class="form-container">
        @csrf
        @method('patch')

        <div class="form-checkbox">
            <label for="is_public">{{ __('Make profile public') }}</label>
            <input type="hidden" name="is_public" value="0">
            <input type="checkbox" name="is_public" id="is_public" value="1" {{ Auth::user()->is_public ? 'checked' : '' }}>
        </div>

        <div class="form-actions">
            <button type="submit" class="save-button">{{ __('Save') }}</button>

            @if (session('status') === 'profile-privacy-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="status-message">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>