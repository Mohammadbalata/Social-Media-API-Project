<?php

use App\Jobs\SendFcmNotification;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


if (!function_exists('authUser')) {
    function authUser(): ?User
    {

        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return null;
        }
        return $user;
    }
}

if (!function_exists("jsonResponse")) {
    function jsonResponse(bool $status, int $code, string $message, array $extraData = []): \Illuminate\Http\JsonResponse
    {
        $responseData = array_merge([
            "status" => $status,
            "code" => $code,
            "message" => $message
        ], $extraData);
        return response()->json($responseData, $code);
    }
}


if (!function_exists('sendNotification')) {
    function sendNotification(array|string $recipients, string $title, string $body, array $data, $saveNotification = true): void
    {
        if (!$saveNotification) {
            Notification::create([
                "title" => $title,
                "body" => $body,
                ...$data
            ]);
        }
        SendFcmNotification::dispatch($recipients, $title, $body, $data);
    }
}

if (!function_exists('findUserOrFail')) {
    function findUserOrFail($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User Not Found.'], 400);
        }
        return $user;
    }
}
