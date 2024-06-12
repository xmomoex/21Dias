<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostReaction;
use Illuminate\Support\Facades\Auth;


class PostReactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'type' => 'required|string|in:like,dislike'
        ]);

        // Buscar si ya existe una reacción del usuario para el post
        $reaction = PostReaction::where('post_id', $request->post_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($reaction) {
            if ($reaction->type == $request->type) {
                $reaction->delete();
            } else {
                $reaction->type = $request->type;
                $reaction->save();
            }
        } else {
            PostReaction::create([
                'post_id' => $request->post_id,
                'type' => $request->type,
                'user_id' => Auth::id()
            ]);
        }

        $likeCount = PostReaction::where('post_id', $request->post_id)->where('type', 'like')->count();
        $dislikeCount = PostReaction::where('post_id', $request->post_id)->where('type', 'dislike')->count();

        // Devolver el tipo de reacción actual del usuario
        $userReaction = PostReaction::where('post_id', $request->post_id)
            ->where('user_id', Auth::id())
            ->first();

        return response()->json([
            'success' => true,
            'likeCount' => $likeCount,
            'dislikeCount' => $dislikeCount,
            'userReaction' => $userReaction ? $userReaction->type : null
        ]);
    }
}
