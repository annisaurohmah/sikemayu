<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('getLogin');
        }

        $user = Auth::user();
        $userRole = $user->role;

        // Check if user role is in allowed roles
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized access');
        }

        // Add user data to request for easy access in controllers
        $request->merge([
            'user_role' => $userRole,
            'user_rw' => $user->no_rw,
            'user_posyandu' => $user->nama_posyandu
        ]);

        return $next($request);
    }
}
