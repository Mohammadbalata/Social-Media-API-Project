<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(
        protected UserRepository $userRepo,
        protected PostRepository $postRepo
    ) {}

    public function searchUser($request)
    {
        $search = $request->input('search');
        $query = $this->userRepo->searchUser($search);
        $users = $query->paginate(10);

        return response()->json($users, 200);
    }

    public function getUserData($user)
    {
        $user->load('posts');
        return response()->json($user, 200);
    }

    public function updateUser($request, $user)
    {
        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $this->userRepo->update($user, $request->validated())
        ], 200);
    }

    public function getUserFollowers($user)
    {
        $followers = $user->followers()->paginate(20);
        return response()->json($followers, 200);
    }

    public function getUserFollowing($user)
    {
        $following = $user->following()->paginate(20);
        return response()->json($following, 200);
    }

    public function followUser($user)
    {
        $authUser = $this->userRepo->findById(Auth::id());

        if ($authUser->id === $user->id) {
            return response()->json(['message' => 'You cannot follow yourself.'], 400);
        }

        if ($authUser->isFollowing($user)) {
            return response()->json(['message' => 'You are already following this user.'], 400);
        }

        $this->userRepo->followUser($authUser, $user);
        return response()->json(['message' => 'success'], 200);
    }

    public function unfollowUser($user)
    {
        $authUser = $this->userRepo->findById(Auth::id());
        if ($authUser->id === $user->id) {
            return response()->json(['message' => 'You cannot unfollow yourself.'], 400);
        }

        if (! $authUser->isFollowing($user)) {
            return response()->json(['message' => 'You are not following this user.'], 400);
        }
        $this->userRepo->unfollowUser($authUser, $user);
        return response()->json(['message' => 'Successfully unfollowed the user.'], 200);
    }

    public function blockUser($user)
    {
        $authUser = $this->userRepo->findById(Auth::id());
        if ($authUser->id === $user->id) {
            return response()->json(['message' => 'You cannot block yourself.'], 400);
        }

        if ($user->isBlocked($authUser)) {
            return response()->json(['message' => 'You cannot block this user.'], 400);
        }

        if ($authUser->isBlocked($user)) {
            return response()->json(['message' => 'You have already blocked this user.'], 400);
        }

        if ($authUser->isFollowing($user)) {
            $this->userRepo->unfollowUser($authUser, $user);
        }

        $this->userRepo->blockUser($authUser, $user);

        return response()->json(['message' => 'Successfully blocked the user.'], 200);
    }

    public function unblockUser($user)
    {
        $authUser = $this->userRepo->findById(Auth::id());
        if ($authUser->id === $user->id) {
            return response()->json(['message' => 'You cannot unblock yourself.'], 400);
        }

        if (!$authUser->isBlocked($user)) {
            return response()->json(['message' => 'You have not blocked this user.'], 400);
        }

        $this->userRepo->unblockUser($authUser, $user);
        return response()->json(['message' => 'Successfully unblocked the user.'], 200);
    }
}
