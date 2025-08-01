<?php

namespace App\Enum;



enum NotificationTypeEnum: string
{
    case GENERAL = 'general';
    case FOLLOW_REQUEST = 'follow_request_sent';
    case FOLLOW_REQUEST_ACCEPTED = 'follow_request_accepted';
    case MESSAGE = 'message';
    case COMMENT = 'comment';
    case POST_LIKE = 'post_like';
    case COMMENT_LIKE = 'comment_like';
    case MENTION = 'mention';
    case REPLY = 'reply';
}
