<?php

namespace App\Services;

use App\Constants\UserConstants;
use App\Enum\FollowRequestStatusEnum;
use App\Http\Resources\FollowRequestResource;
use App\Http\Resources\PaginationResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Models\FollowRequest;
use App\Models\Post;
use App\Models\User;

class UserService extends BaseService
{
    public function __construct(
        protected GeminiService $geminiService
    ) {}

    public function getUserProfileById($user)
    {
        $user->load([
            'following',
            'followers',
        ]);

        return jsonResponse(
            true,
            200,
            UserConstants::USER_PROFILE_RETRIEVED_MESSAGE,
            ['data' => ProfileResource::make($user)]
        );
    }

    public function updateUser($request, $user)
    {
        $user->update($request->validated());

        return jsonResponse(
            true,
            200,
            UserConstants::USER_PROFILE_UPDATED_MESSAGE,
            ['data' => ProfileResource::make($user)]
        );
    }

    public function getUserPosts($user)
    {
        $posts = Post::where('user_id', $user->id)
            ->with(['media', 'likes', 'comments'])
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->paginate(2);

        return jsonResponse(
            true,
            200,
            UserConstants::USER_POSTS_RETRIEVED_MESSAGE,
            ["data" => PaginationResource::make($posts)]
        );
    }

    public function getUserFollowers($user)
    {
        $followers = $user->followers()->paginate(10);

        return jsonResponse(
            true,
            200,
            UserConstants::USER_FOLLOWERS_RETRIEVED_MESSAGE,
            ['data' => UserResource::collection($followers)]
        );
    }

    public function getUserFollowing($user)
    {
        $following = $user->following()->paginate(20);
        return jsonResponse(
            true,
            200,
            UserConstants::USER_FOLLOWING_RETRIEVED_MESSAGE,
            ['data' => UserResource::collection($following)]
        );
    }

    public function followUser($user)
    {
        $authUser = authUser();

        if ($authUser->id === $user->id) {
            return jsonResponse(
                false,
                400,
                UserConstants::USER_FOLLOW_YOURSELF_ERROR_MESSAGE,
            );
        }

        if ($authUser->isFollowing($user)) {
            return jsonResponse(
                false,
                400,
                UserConstants::USER_ALREADY_FOLLOWED_ERROR_MESSAGE,
            );
        }

        if ($user->is_private) {
            // If the user is private, send a follow request
            FollowRequest::firstOrCreate([
                'sender_id' => $authUser->id,
                'receiver_id' => $user->id,
            ]);
        } else {
            $authUser->following()->attach($user);
        }


        sendNotification(
            $user->fcm_tokens,
            'Someone Followed You',
            "@{$user->username} Start Following You",
            ['type' => 'follow', 'user_id' => $user->id]
        );

        return jsonResponse(
            true,
            200,
            UserConstants::USER_HAS_BEED_FOLLOWED_SUCCESSFULLY_MESSAGE,
        );
    }

    public function getUserFollowRequests(User $user)
    {
        $followRequests = $user->receivedFollowRequests()
            ->where('status', FollowRequestStatusEnum::PENDING->value)
            ->paginate(10);
        $followRequests->load(['sender']);
        // return $followRequests;
        return jsonResponse(
            true,
            200,
            UserConstants::USER_FOLLOWING_RETRIEVED_MESSAGE,
            ['data' => PaginationResource::make(FollowRequestResource::collection($followRequests))]
        );
    }

    public function acceptFollowRequest($followRequest)
    {
        $authUser = authUser();
        if ($followRequest->receiver_id !== $authUser->id) {
            return jsonResponse(
                false,
                403,
                UserConstants::UNAUTHORIZED_MESSAGE,
            );
        }
        if ($followRequest->status === FollowRequestStatusEnum::PENDING->value) {
            $followRequest->update(['status' => FollowRequestStatusEnum::ACCEPTED->value]);
        } else {
            return jsonResponse(
                false,
                400,
                'Operation Failed.',
            );
        }
        $authUser->following()->attach($followRequest->sender_id);

        sendNotification(
            $followRequest->sender->fcm_tokens,
            'Accept Follow Request',
            "@{$authUser->username} Accepted Your follow Request",
            ['type' => 'post like', 'user_id' => $authUser->id]
        );

        return jsonResponse(
            true,
            200,
            UserConstants::FOLLOW_REQUEST_ACCEPTED_SUCCESSFULLY_MESSAGE,
        );
    }

    public function rejectFollowRequest($followRequest)
    {
        $authUser = authUser();
        if ($followRequest->receiver_id !== $authUser->id) {
            return jsonResponse(
                false,
                403,
                UserConstants::UNAUTHORIZED_MESSAGE,
            );
        }

        if ($followRequest->status === FollowRequestStatusEnum::PENDING->value) {
            $followRequest->update(['status' => FollowRequestStatusEnum::REJECTED->value]);
        } else {

            return jsonResponse(
                false,
                400,
                'Operation Failed.',
            );
        }

        return jsonResponse(
            true,
            200,
            UserConstants::FOLLOW_REQUEST_REJECTED_SUCCESSFULLY_MESSAGE,
        );
    }

    public function unfollowUser($user)
    {
        $authUser = authUser();
        if ($authUser->id === $user->id) {
            return jsonResponse(
                false,
                400,
                UserConstants::USER_UNFOLLOW_YOURSELF_ERROR_MESSAGE,
            );
        }

        if (! $authUser->isFollowing($user)) {
            return jsonResponse(
                false,
                400,
                UserConstants::USER_ALREADY_UNFOLLOWED_ERROR_MESSAGE,
            );
        }
        $authUser->following()->detach($user);
        return jsonResponse(
            true,
            200,
            UserConstants::USER_HAS_BEED_UNFOLLOWED_SUCCESSFULLY_MESSAGE,
        );
    }

    public function blockUser($user)
    {
        $authUser = authUser();
        if ($authUser->id === $user->id) {
            return jsonResponse(
                false,
                400,
                UserConstants::USER_BLOCK_YOURSELF_ERROR_MESSAGE,
            );
        }

        if ($user->isBlockedBy($authUser)) {
            return jsonResponse(
                false,
                400,
                UserConstants::USER_CANNOT_BE_BLOCKED_ERROR_MESSAGE,
            );
        }

        if ($authUser->isBlockedBy($user)) {

            return jsonResponse(
                false,
                400,
                UserConstants::USER_ALREADY_BLOCKED_ERROR_MESSAGE,
            );
        }

        if ($authUser->isFollowing($user)) {
            $authUser->following()->detach($user);
        }

        $authUser->blockedUsers()->attach($user);
        return jsonResponse(
            true,
            200,
            UserConstants::USER_HAS_BEED_BLOCKED_SUCCESSFULLY_MESSAGE,
        );
    }

    public function unblockUser($user)
    {
        $authUser = authUser();
        if ($authUser->id === $user->id) {
            return jsonResponse(
                false,
                400,
                UserConstants::USER_UNBLOCK_YOURSELF_ERROR_MESSAGE,
            );
        }

        if (!$authUser->isBlockedBy($user)) {
            return jsonResponse(
                false,
                400,
                UserConstants::USER_IS_NOT_BLOCKED_ERROR_MESSAGE,
            );
        }

        $authUser->blockedUsers()->detach($user);
        return jsonResponse(
            true,
            200,
            UserConstants::USER_HAS_BEED_UNBLOCKED_SUCCESSFULLY_MESSAGE,
        );
    }

    public function generateBio($request)
    {
        $intrests = $request->input('intrests');
        $prompt = "generate a bio for a user who loves this intrests ( $intrests ) for a social media account at max 15 words and with this language $intrests return the bio just";
        $response = $this->geminiService->generateContent($prompt);
        $generatedBio = str_replace("\n", '', $response['candidates'][0]['content']['parts'][0]['text']);
        return jsonResponse(
            true,
            200,
            'Bio has been generated successfully',
            ['generated_bio' => $generatedBio]
        );
    }
}

