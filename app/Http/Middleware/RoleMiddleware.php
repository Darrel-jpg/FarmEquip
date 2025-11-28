<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role = null)
    {
        // Jika belum login admin dari API
        if (!session()->has('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        // Jika role ditentukan dan role session tidak sama
        if ($role && session('admin.role') !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
