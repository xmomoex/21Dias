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

        return view('publicprofile', compact('user', 'followersCount', 'followingCount', 'likesCount'));
    }
}
