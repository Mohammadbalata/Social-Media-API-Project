<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Post(
 *     path="/auth/login",
 *     operationId="login",
 *     tags={"Authentication"},
 *     summary="User login",
 *     description="Authenticate a user and return access token",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Login successful"),
 *             @OA\Property(property="data", ref="#/components/schemas/LoginResponse")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Invalid credentials")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
 *     )
 * )
 */
class LoginController extends Controller
{

    // user #2 access_token  // 12|HN6o8wbELpjdholddrRfhWpPDncd9MkGErvCR5ONcef967ef

    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'fcm_token' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        // Store or update the FCM token in the devices table
        // Assumes a Device model with user_id and fcm_token columns
        // Device::updateOrCreate(
        //     [
        //         'user_id' => $user->id,
        //         'fcm_token' => $request->fcm_token,
        //         'device_name' => $request->header('User-Agent'), 
        //         'device_os' => $request->header('X-Device-OS', 'unknown'), 
        //         'device_type' => $request->header('X-Device-Type', 'web'), 
        //         'ip_address' => $request->ip(), 
        //     ]
        // );
        return response()->json(['token' => $token, 'user' => $user], 200);
    }
}
