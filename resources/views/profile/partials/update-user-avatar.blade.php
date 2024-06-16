<style>
    .form-container {
        background-color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 32px;
        width: 100%;
        margin: auto;
    }

    .form-label {
        color: #4A5568;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .form-input {
        display: block;
        width: 100%;
        padding: 8px;
        font-size: 14px;
        color: #1A202C;
        background-color: #F7FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        cursor: pointer;
        margin-bottom: 16px;
    }

    .form-button {
        background-color: #3182CE;
        color: white;
        font-weight: bold;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .form-button:hover {
        background-color: #2B6CB0;
    }

    .avatar-container {
        display: flex;
        align-items: center;
        margin-bottom: 16px;
    }

    .avatar-image {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .remove-button {
        margin-left: 16px;
        background-color: #E53E3E;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .remove-button:hover {
        background-color: #C53030;
    }

    .no-avatar {
        color: #A0AEC0;
        margin-bottom: 16px;
    }
</style>
<section>
    <form action="{{ route('profile.updateAvatar') }}" method="POST" enctype="multipart/form-data" class="form-container">
        @csrf

        <!-- Otras entradas de perfil -->

        <div>
            <label for="avatar" class="form-label">Avatar:</label>
            @if(auth()->user()->avatar_path)
            <div class="avatar-container">
                <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="Avatar" class="avatar-image">
                <button type="submit" name="remove_avatar" class="remove-button">Eliminar Avatar</button>
            </div>
            @else
            <p class="no-avatar">No hay avatar</p>
            @endif
            <input type="file" name="avatar" id="avatar" accept="image/*" class="form-input">
        </div>

        <button type="submit" class="form-button">Guardar Cambios</button>
    </form>
</section>