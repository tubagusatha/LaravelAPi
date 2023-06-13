<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only('logout', 'me');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'

        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($user->username)->plainTextToken;
    }

    public function logout(Request $request)
    {
        $user =  Auth::user()->email;

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'messege' => 'anda telah logout dari akun',
            'user' => $user
        ]);
    }

    public function me(Request $request)
    {

        $user = Auth::user();

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
        ]);
    }


    public function Register(Request $request)
    {
        $request->validate([
            'name' => 'min:2|max:10',
            'email' => 'email|unique:users',
            'password' => 'min:2',
        ]);

        User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'password' => Hash::make($request->input('password'))
        ]);

        return response()->json([
            'message' => 'User berhasil dibuat'
        ]);
    }
}
