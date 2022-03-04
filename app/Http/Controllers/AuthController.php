<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerAdmin(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:admins,email',
            'password' => 'required|string|confirmed',
        ]);

        $admin = Admin::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $admin->createToken($request->userAgent())->plainTextToken;

        $response = [
            'admin' => $admin,
            'token' => $token,
        ];

        return response($response, 201);

    }

    public function loginAdmin(Request $request)
    {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $admin = Admin::where('email', $fields['email'])->first();

        if (!$admin || !Hash::check($fields['password'], $admin->password)) {
            return response(['message' => 'Invalid login']);
        } else {

            $admin->tokens()->delete();
            $token = $admin->createToken($request->userAgent())->plainTextToken;

            $response = [
                'admin' => $admin,
                'token' => $token,
                'message' => 'success',
            ];

            return response($response, 201);
        }

    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'logged out',
        ])
        ;
    }
}
