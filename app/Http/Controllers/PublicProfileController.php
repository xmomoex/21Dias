<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PublicProfileController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);

        // Número de seguidores
        $followersCount = $user->followers()->count();

        // Número de personas a las que sigue
        $followingCount = $user->following()->count();

        // Contar likes recibidos en todas las publicaciones del usuario
        $likesCount = DB::table('post_reactions')
            ->join('posts', 'post_reactions.post_id', '=', 'posts.id')
            ->where('posts.user_id', $id)
            ->where('post_reactions.type', 'like')
            ->count();

        $posts = Post::where('user_id', $user->id)
            ->where(function ($query) use ($user) {
                $query->where('is_public', '1')
                    ->orWhere(function ($query) use ($user) {
                        if (Auth::id() === $user->id) {
                            $query->orWhere('is_public', '0');
                        } else {
                            $query->where('is_public', '0')
                                ->whereHas('user.followers', function ($q) use ($user) {
                                    $q->where('follower_id', Auth::id());
                                });
                        }
                    });
            })
            ->orderByDesc('created_at') // Ordenar por fecha de creación, más nuevo primero
            ->get();

        $isFollowing = Auth::user()->following->contains($user->id);
        $isOwnProfile = Auth::id() === $user->id;

        return view('publicprofile', compact('user', 'followersCount', 'followingCount', 'likesCount', 'posts', 'isFollowing', 'isOwnProfile'));
    }
}
