<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Check if the user's status is frozen or deactivated
        if (in_array($user->status, ['frozen', 'deactivated'])) {
            abort(403, 'Access Denied. Your account is restricted.');
        }

        // Check if the user role matches the required role
        if ($user->role !== $role) {
            return back();
        }

        return $next($request);
    }
}
