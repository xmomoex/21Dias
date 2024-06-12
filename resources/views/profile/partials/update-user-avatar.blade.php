<form action="{{ route('profile.updateAvatar') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Otras entradas de perfil -->

    <div>
        <label for="avatar">Avatar:</label>
        @if(auth()->user()->avatar_path)
        <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="Avatar" class="w-12 h-12 rounded-full mb-2">
        <button type="submit" name="remove_avatar" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Eliminar Avatar</button>
        @else
        <p>No hay avatar</p>
        @endif
        <input type="file" name="avatar" id="avatar" accept="image/*" class="mb-2">
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Guardar Cambios</button>
</form>