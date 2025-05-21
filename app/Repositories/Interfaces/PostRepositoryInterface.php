<?php

namespace App\Repositories\Interfaces;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
   
    //  Feed and post retrieval
    public function getPostFeed(User $user, int $limit = 10);
    // public function getUserPosts(User $user, int $limit = 10);
    // public function getPopularPosts(int $limit = 10);
    // public function getPublicPosts(int $limit = 10);
    // public function getPinnedPosts(User $user);
    // public function getFriendsOnlyPosts(User $user);

    // // Post details and search
    // public function searchPosts(string $query, int $limit = 10);
    // public function getPostWithComments(int $postId, int $commentsLimit = 10);

    // // Comments and replies
    // public function getComments(Post $post, int $limit = 10);
    // public function getReplies(Comment $comment, int $limit = 10);

    // // Media and mentions
    // public function attachMedia(Post $post, array $mediaFiles): void;
    // public function getMentions(Post $post);

    // // Post management
    // public function togglePin(Post $post): void;
    // public function togglePrivacy(Post $post, string $privacy): void;
}