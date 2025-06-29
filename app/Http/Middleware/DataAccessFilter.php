<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class DataAccessFilter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('getLogin');
        }

        $user = Auth::user();
        
        // Get posyandu data for sidebar
        $posyandus = \App\Models\Posyandu::all();
        
        // Share user access data with all views
        View::share('userRole', $user->role);
        View::share('userRW', $user->no_rw);
        View::share('userPosyandu', $user->nama_posyandu);
        View::share('posyandus', $posyandus);

        // Add access control data to request
        $request->merge([
            'user_access_data' => [
                'role' => $user->role,
                'rw' => $user->no_rw,
                'posyandu' => $user->nama_posyandu,
                'can_access_all' => $user->role === 'admin_desa',
                'can_access_rw_only' => $user->role === 'admin_rw' && !empty($user->no_rw) && empty($user->nama_posyandu),
                'can_access_posyandu_only' => $user->role === 'admin_kader' && !empty($user->nama_posyandu)
            ]
        ]);

        return $next($request);
    }
}
