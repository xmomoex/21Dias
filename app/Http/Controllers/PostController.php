<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Challenge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            return response()->json(['success' => true, 'message' => 'Post deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
    }



    public function create()
    {
        $challenges = Challenge::all();
        return view('posts.create', compact('challenges'));
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

        $post = Post::create([
            'user_id' => Auth::id(),
            'body' => $request->body,
            'group_id' => $request->group_id,
            'file_path' => $filePath,
            'is_public' => $isPublic,
        ]);

        if ($request->challenge_id) {
            $post->challenges()->attach($request->challenge_id);
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function index()
    {
        if (Auth::check()) {
            // Obtén los posts públicos y los del usuario autenticado, ordenados por fecha de creación en orden descendente
            $posts = Post::where('is_public', true)
                ->orWhere('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Obtén solo los posts públicos, ordenados por fecha de creación en orden descendente
            $posts = Post::where('is_public', true)
                ->orderBy('created_at', 'desc')
                ->get();
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
