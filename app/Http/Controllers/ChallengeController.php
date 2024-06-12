<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function index()
    {
        $challenges = Challenge::all();
        return view('challenges.index', compact('challenges'));
    }

    public function create()
    {
        return view('challenges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Challenge::create($request->all());
        return redirect()->route('challenges.index')->with('success', 'Challenge created successfully.');
    }

    public function showPosts(Challenge $challenge)
    {
        $posts = $challenge->posts()->with('user')->get();
        return view('challenges.post', compact('challenge', 'posts'));
    }
}
