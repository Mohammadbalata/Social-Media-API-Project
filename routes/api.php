<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Comments\CommentReplyController;
use App\Http\Controllers\Api\Comments\CommentsController;
use App\Http\Controllers\Api\Comments\LikeCommentController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\Posts\LikePostController;
use App\Http\Controllers\Api\Posts\PostCommentController;
use App\Http\Controllers\Api\Posts\PostsController;
use App\Http\Controllers\Api\Tags\TagsController;
use App\Http\Controllers\Api\Users\BlockController;
use App\Http\Controllers\Api\Users\FollowController;
use App\Http\Controllers\Api\Users\UsersController;
use Illuminate\Support\Facades\Route;



// Auth Routes
Route::post('/auth/register', RegisterController::class);
Route::post('/auth/login', LoginController::class);


Route::get('/users', [UsersController::class, 'searchUser']);
Route::get('/users/{user}', [UsersController::class, 'getUserData']);

Route::get('/users/{user}/followers', [FollowController::class, 'getUserFollowers']);
Route::get('/users/{user}/following', [FollowController::class, 'getUserFollowing']);


Route::get('/posts', [HomeController::class, 'getFeed']);
Route::get('/posts/{post}', [PostsController::class, 'getPost'])->middleware('check.block:post');

Route::get('/comments/{comment}', [CommentsController::class, 'getComment'])->middleware('check.block:comment');

Route::get('/tags', [TagsController::class, 'getTags']);
Route::get('/tags/{tag}/posts', [TagsController::class, 'getTagPosts']);
Route::get('/tags/{tag}/comments', [TagsController::class, 'getTagComments']);

Route::middleware('auth:sanctum')->group(function () {

  // User Routes
  Route::post('/auth/logout', LogoutController::class);
  Route::put('/users/{user}', [UsersController::class, 'updateUser']);
  Route::post('/users/{user}/block', [BlockController::class, 'blockUser']);
  Route::delete('/users/{user}/unblock', [BlockController::class, 'unblockUser']);
  Route::middleware('check.block:user')->group(function () {
    Route::post('/users/{user}/follow', [FollowController::class, 'followUser']);
    Route::delete('/users/{user}/unfollow', [FollowController::class, 'unfollowUser']);
  });

  Route::get('/user/generate-bio',[UsersController::class,'generateBio']);

  // Post Routes
  Route::post('/posts', [PostsController::class, 'createPost']);
  Route::put('/posts/{post}', [PostsController::class, 'updatePost']);
  Route::delete('/posts/{post}', [PostsController::class, 'deletePost']);
  Route::middleware('check.block:post')->group(function () {
    Route::post('/posts/{post}/like', [LikePostController::class, 'likePost']);
    Route::delete('/posts/{post}/unlike', [LikePostController::class, 'unlikePost']);

    Route::get('/posts/{post}/comments', [PostCommentController::class, 'getPostComments']);
    Route::post('/posts/{post}/comments', [PostCommentController::class, 'addCommentToPost']);
  });

  // Comment Routes
  Route::middleware('check.block:comment')->group(function () {
    Route::post('/comments/{comment}/like', [LikeCommentController::class, 'likeComment']);
    Route::delete('/comments/{comment}/unlike', [LikeCommentController::class, 'unlikeComment']);
  });
  Route::put('/comments/{comment}', [CommentsController::class, 'updateComment']);
  Route::delete('/comments/{comment}', [CommentsController::class, 'deleteComment']);

  Route::post('/comments/{comment}/reply', [CommentReplyController::class, 'replyToComment']);
});
