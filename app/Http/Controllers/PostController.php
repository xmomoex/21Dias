<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //

    public function destroy($id)
    {
        $post = Post::find($id);

        if ($post) {
            $post->deleted_by = Auth::id();
            $post->save();
            $post->delete();
        }

        return redirect()->route('home')->with('success', 'Post deleted successfully.');
    }



    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'group_id' => 'nullable|exists:groups,id',
            'file' => 'nullable|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:2048', // Limitar tipos de archivo y tamaño
            'is_public' => 'nullable|boolean', // Nuevo campo para la privacidad del post
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('posts', 'public');
        }


        // Asignar el valor de is_public o establecerlo por defecto a true si no se proporciona
        $isPublic = $request->has('is_public') ? $request->is_public : true;

        Post::create([
            'user_id' => Auth::id(),
            'body' => $request->body,
            'group_id' => $request->group_id,
            'file_path' => $filePath,
            'is_public' => $isPublic,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function index()
    {
        if (Auth::check()) {
            $posts = Post::where('is_public', true)->orWhere('user_id', Auth::id())->get();
        } else {
            $posts = Post::where('is_public', true)->get();
        }

        return view('dashboard', compact('posts'));
    }

    public function myPosts()
    {
        $user = Auth::user();
        $posts = Post::where('user_id', $user->id)->get();

        return view('posts.myPosts', compact('posts'));
    }

    public function followingPosts()
    {
        $followingIds = Auth::user()->following()->pluck('users.id');
        $posts = Post::whereIn('user_id', $followingIds)->latest()->get();

        return view('posts.following', compact('posts'));
    }
}
