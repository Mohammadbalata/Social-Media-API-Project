<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIfBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type): Response
    {
        $user  = Auth::guard('sanctum')->user();
        $targetUser = match ($type) {
            'user' => $request->route('user'),
            'post' => $request->route('post')->user,
            'comment' => $request->route('comment')->user,
            default => null
        };
        if (!$targetUser) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        if ($user && ($targetUser->isBlockedBy($user) || $user->isBlockedBy($targetUser))) {
            return response()->json(
                ['message' => "You cannot interact with this {$type} due to blocked relationship"],
                403
            );
        }

        return $next($request);
    }
}
