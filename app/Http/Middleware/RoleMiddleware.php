<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->role) {
            abort(403, 'Unauthorized. No role assigned.');
        }

        foreach ($roles as $role) {

            // Check by ID (numeric)
            if (is_numeric($role) && (int)$user->role->id === (int)$role) {
                return $next($request);
            }

            // Check by name (string)
            if (is_string($role) && $user->role->name === $role) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized. You do not have the required role.');
    }
}