<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostReactionController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FollowRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('auth.verify-email');


Route::get('/', function () {
    return redirect()->route('login');
});

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::resource('challenges', ChallengeController::class);


//Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/posts/{posts}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.myPosts');
    Route::post('/reactions', [PostReactionController::class, 'store'])->name('reactions.store');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/publicprofile/{id}', [PublicProfileController::class, 'show'])->name('publicprofile.show');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/follow', [UserController::class, 'follow'])->name('users.follow');
    Route::post('/users/{id}/unfollow', [UserController::class, 'unfollow'])->name('users.unfollow');
    Route::get('/posts/following', [PostController::class, 'followingPosts'])->name('posts.following');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index')->middleware('auth');
    Route::get('/messages/chat/{id}', [MessageController::class, 'chat'])->name('messages.chat')->middleware('auth');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store')->middleware('auth');
    Route::get('/follow-requests', [FollowRequestController::class, 'index'])->name('follow_requests.index')->middleware('auth');
    Route::post('/follow-requests/accept/{id}', [FollowRequestController::class, 'accept'])->name('follow_requests.accept')->middleware('auth');
    Route::post('/follow-requests/decline/{id}', [FollowRequestController::class, 'decline'])->name('follow_requests.decline')->middleware('auth');
    Route::patch('/profile/privacy', [ProfileController::class, 'updatePrivacy'])->name('profile.updatePrivacy');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{id}/react', [CommentController::class, 'react'])->name('comments.react');
    Route::delete('/comments/{id}/remove-reaction', [CommentController::class, 'removeReaction'])->name('comments.removeReaction');
    Route::get('/challenges/{challenge}/posts', [ChallengeController::class, 'showPosts'])->name('challenges.posts');
    Route::post('profile/update-avatar', [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');
    Route::post('profile/remove-avatar', [ProfileController::class, 'removeAvatar'])->name('profile.removeAvatar');
});

require __DIR__ . '/auth.php';
