<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminIsAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // Check if admin is authenticated
        if (!Auth::guard('admin')->check()) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $admin = Auth::guard('admin')->user();

        // Check if admin account is active
        if (!$admin->is_active) {
            Auth::guard('admin')->logout();
            return response()->json([
                'message' => 'Admin account is not active'
            ], 403);
        }

        // Check if password change is required
        if ($admin->mustChangePassword()) {
            return response()->json([
                'message' => 'Password change required',
                'must_change_password' => true
            ], 403);
        }

        return $next($request);
    }
}
