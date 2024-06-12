<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function updatePrivacy(Request $request)
    {
        $request->validate([
            'is_public' => 'required|boolean',
        ]);

        $user = Auth::user();
        $user->is_public = $request->is_public;
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile privacy updated successfully.');
    }



    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Eliminar el avatar anterior si existe
        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        // Guardar el nuevo avatar
        $avatarPath = $request->file('avatar')->store('avatars', 'public');

        // Actualizar el campo avatar_path en la base de datos
        $user->avatar_path = $avatarPath;
        $user->save();

        return redirect()->back()->with('success', 'Avatar actualizado correctamente.');
    }

    /**
     * Remove the user's avatar.
     */
    public function removeAvatar(Request $request)
    {
        $user = Auth::user();

        // Eliminar el avatar anterior si existe
        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->avatar_path = null;
            $user->save();
            return redirect()->back()->with('success', 'Avatar eliminado correctamente.');
        }

        return redirect()->back()->with('error', 'No hay avatar para eliminar.');
    }
}
