<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
          'email' => 'required',
          'password' => 'required'
        ]);

        $user = User::where('email', $fields['email'])->first();
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json(['error' => 'The provided credentials are incrorrect'], 401);
        }

        $token = $user->createToken($fields['email'])->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }
}
