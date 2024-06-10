<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\FollowRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNotNull('email_verified_at')
            ->where('id', '!=', Auth::id())
            ->get();
        return view('users.index', compact('users'));
    }

    public function follow($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_public) {
            Auth::user()->following()->attach($user->id);
            return redirect()->route('users.index')->with('success', 'You are now following ' . $user->name);
        } else {
            FollowRequest::create([
                'user_id' => $user->id,
                'follower_id' => Auth::id(),
            ]);
            return redirect()->route('users.index')->with('success', 'Follow request sent to ' . $user->name);
        }
    }

    public function unfollow($id)
    {
        $user = User::findOrFail($id);
        Auth::user()->following()->detach($user->id);
        return redirect()->route('users.index')->with('success', 'You have unfollowed ' . $user->name);
    }
}
