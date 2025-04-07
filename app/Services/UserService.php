<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(
        protected UserRepository $userRepo,
    ) {}

    public function searchUser($request)
    {
        $search = $request->input('search');
        $query = User::query();
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $query->select('id', 'username', 'email', 'profile_image', 'verified');

        $users = $query->paginate(10);

        return response()->json($users, 200);
    }

    public function getUserData($user)
    {
        return new UserResource($user);
    }

    public function updateUser($request, $user)
    {
        $user->update($request->validated());
        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user
        ], 200);
    }

    public function getUserFollowers($user)
    {
        $followers = $user->followers()->paginate(10);
        return response()->json($followers, 200);
    }

    public function getUserFollowing($user)
    {
        $following = $user->following()->paginate(20);
        return response()->json($following, 200);
    }

    public function followUser($user)
    {
        $authUser = User::find(Auth::id());

        if ($authUser->id === $user->id) {
            return response()->json(['message' => 'You cannot follow yourself.'], 400);
        }

        if ($authUser->isFollowing($user)) {
            return response()->json(['message' => 'You are already following this user.'], 400);
        }

        $authUser->following()->attach($user);
        return response()->json(['message' => 'success'], 200);
    }

    public function unfollowUser($user)
    {
        $authUser = User::find(Auth::id());
        if ($authUser->id === $user->id) {
            return response()->json(['message' => 'You cannot unfollow yourself.'], 400);
        }

        if (! $authUser->isFollowing($user)) {
            return response()->json(['message' => 'You are not following this user.'], 400);
        }
        $authUser->following()->detach($user);
        return response()->json(['message' => 'Successfully unfollowed the user.'], 200);
    }

    public function blockUser($user)
    {
        $authUser = User::find(Auth::id());
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
            $authUser->following()->detach($user);
        }

        $authUser->blockedUsers()->attach($user);

        return response()->json(['message' => 'Successfully blocked the user.'], 200);
    }

    public function unblockUser($user)
    {
        $authUser = User::find(Auth::id());
        if ($authUser->id === $user->id) {
            return response()->json(['message' => 'You cannot unblock yourself.'], 400);
        }

        if (!$authUser->isBlocked($user)) {
            return response()->json(['message' => 'You have not blocked this user.'], 400);
        }

        $authUser->blockedUsers()->detach($user);
        return response()->json(['message' => 'Successfully unblocked the user.'], 200);
    }
}
