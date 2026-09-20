<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // DEBUG STEP: This will print straight to your Laravel terminal
        if (!$user) {
            \Log::info('Login failed: User not found for email: ' . $request->email);
            return response()->json(['message' => 'User not found'], 404);
        }

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            \Log::info('Login failed: Password mismatch for user: ' . $request->email);
            return response()->json(['message' => 'Incorrect password'], 401);
        }

        $token = $user->createToken('mobile_app_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }
}
