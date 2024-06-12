<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\CommentReaction;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        Comment::create([
            'post_id' => $request->post_id,
            'comment' => $request->comment,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function react(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:like,dislike',
        ]);

        $comment = Comment::findOrFail($id);
        $reaction = CommentReaction::updateOrCreate(
            [
                'comment_id' => $comment->id,
                'user_id' => Auth::id(),
            ],
            [
                'type' => $request->type,
            ]
        );

        return redirect()->back()->with('success', 'Reaction added successfully.');
    }

    public function removeReaction($id)
    {
        $reaction = CommentReaction::where('comment_id', $id)->where('user_id', Auth::id())->first();
        if ($reaction) {
            $reaction->delete();
        }

        return redirect()->back()->with('success', 'Reaction removed successfully.');
    }


    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this comment.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
