<?php

use App\Models\User;
use App\Services\NotificationService;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Comments\CommentReplyController;
use App\Http\Controllers\Api\Comments\CommentsController;
use App\Http\Controllers\Api\Comments\LikeCommentController;
use App\Http\Controllers\Api\HomePageController;
use App\Http\Controllers\Api\Posts\PostInteractionsController;
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


Route::get('/search', [HomePageController::class, 'search']);
Route::get('/users/{user}', [UsersController::class, 'getUserProfileById']);

Route::get('/users/{user}/followers', [FollowController::class, 'getUserFollowers']);
Route::get('/users/{user}/following', [FollowController::class, 'getUserFollowing']);


Route::get('/posts', [HomePageController::class, 'getFeed']);
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
    Route::get('/users/{user}/posts', [UsersController::class, 'getUserPosts']);
    Route::post('/users/{user}/follow', [FollowController::class, 'followUser']);
    Route::delete('/users/{user}/unfollow', [FollowController::class, 'unfollowUser']);
  });

  Route::get('/users/{user}/followrequests', [FollowController::class, 'getUserFollowRequests']);
  Route::post('/followrequests/{followRequest}/accept', [FollowController::class, 'acceptFollowRequest']);
  Route::post('/followrequests/{followRequest}/reject', [FollowController::class, 'rejectFollowRequest']);
  Route::get('/users/generate-bio', [UsersController::class, 'generateBio']);

  // Post Routes
  Route::post('/posts', [PostsController::class, 'createPost']);
  Route::put('/posts/{post}', [PostsController::class, 'updatePost']);
  Route::delete('/posts/{post}', [PostsController::class, 'deletePost']);
  Route::middleware('check.block:post')->group(function () {
    Route::post('/posts/{post}/like', [PostInteractionsController::class, 'likePost']);
    Route::delete('/posts/{post}/unlike', [PostInteractionsController::class, 'unlikePost']);

    Route::get('/posts/{post}/comments', [PostCommentController::class, 'getPostComments']);
    Route::post('/posts/{post}/comments', [PostCommentController::class, 'addCommentToPost']);

    Route::post('/posts/{post}/pin', [PostInteractionsController::class, 'pinPost']);
    Route::post('/posts/{post}/unpin', [PostInteractionsController::class, 'unpinPost']);
  });

  // Comment Routes
  Route::middleware('check.block:comment')->group(function () {
    Route::post('/comments/{comment}/like', [LikeCommentController::class, 'likeComment']);
    Route::delete('/comments/{comment}/unlike', [LikeCommentController::class, 'unlikeComment']);
    Route::get('/comments/{comment}/replies', [CommentReplyController::class, 'getCommentReplies']);
  });
  Route::put('/comments/{comment}', [CommentsController::class, 'updateComment']);
  Route::delete('/comments/{comment}', [CommentsController::class, 'deleteComment']);

  Route::post('/comments/{comment}/reply', [CommentReplyController::class, 'replyToComment']);
});

Route::get('/send-dummy-notification', function () {
  $user = User::find(1);
  $fcmTokens =  $user->fcm_tokens;
  app(NotificationService::class)->send(
    $fcmTokens,
    '🔔 Test Notification',
    'This is a dummy notification message.',
    ['type' => 'test', 'user_id' => $user->id]
  );
  return response()->json(['message' => 'Notification sent to user ID 1']);
});
