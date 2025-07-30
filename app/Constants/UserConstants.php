<?php

namespace App\Constants;

class UserConstants
{
    public const UNAUTHORIZED_MESSAGE = 'Unauthorized action.';

    public const USER_PROFILE_RETRIEVED_MESSAGE = 'User profile retrieved successfully.';
    public const USER_PROFILE_UPDATED_MESSAGE = 'User profile updated successfully.';
    public const USER_POSTS_RETRIEVED_MESSAGE = 'User posts retrieved successfully.';
    public const USER_FOLLOWERS_RETRIEVED_MESSAGE = 'User followers retrieved successfully.';
    public const USER_FOLLOWING_RETRIEVED_MESSAGE = 'User following retrieved successfully.';

    public const USER_FOLLOW_YOURSELF_ERROR_MESSAGE = 'You cannot follow yourself.';
    public const USER_ALREADY_FOLLOWED_ERROR_MESSAGE = 'You are already following this user.';
    public const USER_HAS_BEED_FOLLOWED_SUCCESSFULLY_MESSAGE = 'Follow request sent successfully.';
    public const FOLLOW_REQUEST_ACCEPTED_SUCCESSFULLY_MESSAGE = 'Follow request accepted successfully.';
    public const FOLLOW_REQUEST_REJECTED_SUCCESSFULLY_MESSAGE = 'Follow request rejected successfully.';

    public const USER_UNFOLLOW_YOURSELF_ERROR_MESSAGE = 'You cannot unfollow yourself.';
    public const USER_ALREADY_UNFOLLOWED_ERROR_MESSAGE = 'You are not following this user.';
    public const USER_HAS_BEED_UNFOLLOWED_SUCCESSFULLY_MESSAGE = 'User has been unfollowed successfully';

    public const USER_BLOCK_YOURSELF_ERROR_MESSAGE = 'You cannot block yourself.';
    public const USER_CANNOT_BE_BLOCKED_ERROR_MESSAGE = 'You cannot block this user.';
    public const USER_ALREADY_BLOCKED_ERROR_MESSAGE = 'You are already blocking this user.';
    public const USER_HAS_BEED_BLOCKED_SUCCESSFULLY_MESSAGE = 'User has been blocked successfully';

    public const USER_UNBLOCK_YOURSELF_ERROR_MESSAGE = 'You cannot unblock yourself.';
    public const USER_IS_NOT_BLOCKED_ERROR_MESSAGE = 'You have not blocked this user.';
    public const USER_HAS_BEED_UNBLOCKED_SUCCESSFULLY_MESSAGE = 'User has been unblocked successfully';


}
