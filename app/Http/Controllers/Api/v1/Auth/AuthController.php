<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    /**
     * Login user and return an access token.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->accessToken;

            Log::info('User logged in successfully', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_id' => $user->id
            ]);

            return response()->json([
                'user' => $user,
                "message" => "User logged in successfully.",
                'access_token' => "Bearer " . $token,
            ], 200);
        }

        Log::error('Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'status' => 'failed'
        ]);

        return response()->json([
            'message' => 'Invalid login credentials.',
        ], 401);
    }

    /**
     * Logout user and revoke the access token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            // Log unauthenticated logout attempt (error level)
            Log::error('Unauthenticated user attempted to logout', [
                'ip' => $request->ip()
            ]);

            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Revoke the user's token
        $request->user()->token()->revoke();

        // Log successful logout attempt (info level)
        Log::info('User logged out successfully', [
            'user_id' => $request->user()->id,
            'ip' => $request->ip()
        ]);

        return response()->json([
            'message' => 'User logged out successfully!'
        ], 200);
    }



 


 

 
 
}
