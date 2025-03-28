<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\PasswordChangeRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        \Log::debug('Login attempt', $request->all());

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided pass credentials are incorrect.'],
            ]);
        }

        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'admin' => $admin,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Make sure this line is present
        ]);

        $token = $admin->createToken('remember_token')->plainTextToken;

        return response()->json([
            'admin' => $admin,
            'token' => $token,
        ], 201);
    }

//    public function changePassword(PasswordChangeRequest $request)
//    {
//        $admin = Auth::guard('admin')->user();
//
//        // Verify current password
//        if (!Hash::check($request->current_password, $admin->password)) {
//            return response()->json([
//                'message' => 'Current password is incorrect'
//            ], 422);
//        }
//
//        // Update password
//        $admin->update([
//            'password' => $request->password,
//            'must_change_password' => false
//        ]);
//
//        return response()->json([
//            'message' => 'Password successfully updated'
//        ]);
//    }

public function test()
{

    setcookie('testCookie 2', 'hello from cookie');

    return response()->json([
        'message' => 'test hello from AdminAuthController',
    ]);
}

}
