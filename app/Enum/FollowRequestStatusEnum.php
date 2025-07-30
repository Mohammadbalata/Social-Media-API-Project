<?php

namespace App\Enum;

enum FollowRequestStatusEnum: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public static function values(): array
    {
        return [
            self::PENDING,
            self::ACCEPTED,
            self::REJECTED,
        ];
    }

    public static function isValid(string $status): bool
    {
        return in_array($status, self::values(), true);
    }
}
