<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;


class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $posts = Post::where('is_public', true)
                ->orWhere('user_id', Auth::id())
                ->get();
        } else {
            $posts = Post::where('is_public', true)
                ->get();
        }

        return view('dashboard', compact('posts'));
    }
}
