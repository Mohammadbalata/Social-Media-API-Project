<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\Route;



// Auth Routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);


Route::get('/users', [UsersController::class, 'searchUser']);
Route::get('/users/{user}', [UsersController::class, 'getUserData']);

Route::get('/users/{user}/followers', [UsersController::class, 'getUserFollowers']);
Route::get('/users/{user}/following', [UsersController::class, 'getUserFollowing']);


Route::get('/posts', [PostsController::class, 'getAllPosts']);
Route::get('/posts/{post}', [PostsController::class, 'getPost']);

Route::middleware('auth:sanctum')->group(function () {

  // User Routes
  Route::post('/auth/logout', [AuthController::class, 'logout']);
  Route::put('/users/{user}', [UsersController::class, 'updateUser']);
  Route::post('/users/{user}/block', [UsersController::class, 'blockUser']);
  Route::delete('/users/{user}/unblock', [UsersController::class, 'unblockUser']);
  Route::middleware('check.block:user')->group(function () {
    Route::post('/users/{user}/follow', [UsersController::class, 'followUser']);
    Route::delete('/users/{user}/unfollow', [UsersController::class, 'unfollowUser']);
  });

  // Post Routes
  Route::post('/posts', [PostsController::class, 'createPost']);
  Route::put('/posts/{post}', [PostsController::class, 'updatePost']);
  Route::delete('/posts/{post}', [PostsController::class, 'deletePost']);
  Route::middleware('check.block:post')->group(function () {
    Route::post('/posts/{post}/like', [PostsController::class, 'likePost']);
    Route::delete('/posts/{post}/unlike', [PostsController::class, 'unlikePost']);
    Route::get('/posts/{post}/comments', [CommentsController::class, 'getPostComments']);
    Route::post('/posts/{post}/comments', [CommentsController::class, 'addCommentToPost']);
  });

  // Comment Routes
  Route::middleware('check.block:comment')->group(function () {
    Route::post('/comments/{comment}/like', [CommentsController::class, 'likeComment']);
    // Route::get('/comments/{comment}', [CommentsController::class, 'getComment']);
    Route::delete('/comments/{comment}/unlike', [CommentsController::class, 'unlikeComment']);
  });
  Route::put('/comments/{comment}', [CommentsController::class, 'updateComment']);
  Route::delete('/comments/{comment}', [CommentsController::class, 'deleteComment']);
});
