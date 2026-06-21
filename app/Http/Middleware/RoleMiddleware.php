<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $roles)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $allowedRoles = array_map('trim', explode(',', $roles));

        if (!in_array($user->role, $allowedRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
