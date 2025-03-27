<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\PasswordChangeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::guard('admin')->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $admin = Auth::guard('admin')->user();

        // Check if admin is active
        if (!$admin->is_active) {
            Auth::guard('admin')->logout();
            return response()->json([
                'message' => 'Admin account is not active'
            ], 403);
        }

        // Update login metadata
        $admin->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip()
        ]);

        // Create token
        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'admin' => $admin,
            'token' => $token,
            'must_change_password' => $admin->mustChangePassword()
        ]);
    }

    public function changePassword(PasswordChangeRequest $request)
    {
        $admin = Auth::guard('admin')->user();

        // Verify current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return response()->json([
                'message' => 'Current password is incorrect'
            ], 422);
        }

        // Update password
        $admin->update([
            'password' => $request->password,
            'must_change_password' => false
        ]);

        return response()->json([
            'message' => 'Password successfully updated'
        ]);
    }

    public function logout()
    {
        $admin = Auth::guard('admin')->user();
        $admin->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
