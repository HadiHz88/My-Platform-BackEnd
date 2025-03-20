<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        if (Auth::user()->role != $role) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
