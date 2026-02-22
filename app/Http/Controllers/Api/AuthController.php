<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            return new ApiResource(null, false, 'Validasi gagal', $validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return new ApiResource($user, true, 'User registered successfully');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if ($validator->fails()) {
            return new ApiResource(null, false, 'Validasi gagal', $validator->errors());
        }

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('KasirApotek')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return new ApiResource(null, false, 'Invalid email or password');
    }
}
