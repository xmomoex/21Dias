<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FollowRequest;
use Illuminate\Support\Facades\Auth;

class FollowRequestController extends Controller
{
    public function index()
    {
        $requests = Auth::user()->followRequests;
        return view('follow_requests.index', compact('requests'));
    }

    public function accept($id)
    {
        $request = FollowRequest::findOrFail($id);
        Auth::user()->followers()->attach($request->follower_id);
        $request->delete();

        return redirect()->route('follow_requests.index')->with('success', 'Follow request accepted.');
    }

    public function decline($id)
    {
        $request = FollowRequest::findOrFail($id);
        $request->delete();

        return redirect()->route('follow_requests.index')->with('success', 'Follow request declined.');
    }
}
