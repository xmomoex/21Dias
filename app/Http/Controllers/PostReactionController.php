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
            // Si la reacción existe y el tipo es el mismo, eliminar la reacción
            if ($reaction->type == $request->type) {
                $reaction->delete();
            } else {
                // Si el tipo es diferente, actualizar la reacción
                $reaction->type = $request->type;
                $reaction->save();
            }
        } else {
            // Si no existe, crear una nueva
            PostReaction::create([
                'post_id' => $request->post_id,
                'type' => $request->type,
                'user_id' => Auth::id()
            ]);
        }

        return back()->with('success', 'Reaction added/updated successfully.');
    }
}
