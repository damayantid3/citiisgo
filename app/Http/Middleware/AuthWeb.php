<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthWeb
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!session('api_token')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = session('user_role');

        if (!empty($roles) && !in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}