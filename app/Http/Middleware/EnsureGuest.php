<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureGuest
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('auth')) {
            return redirect(session('auth.role') === 'admin' ? '/admin/dashboard' : '/user/dashboard');
        }

        return $next($request);
    }
}
