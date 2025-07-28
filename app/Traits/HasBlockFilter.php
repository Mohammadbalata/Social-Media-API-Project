<?php

namespace App\Traits;

use App\Models\Scopes\ExcludeBlockedUsersScope;

trait HasBlockFilter
{
    protected static function bootHasBlockFilter()
    {
        static::addGlobalScope(new ExcludeBlockedUsersScope);
    }
}

