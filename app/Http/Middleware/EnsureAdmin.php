<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('auth.role') !== 'admin') {
            return redirect('/user/dashboard');
        }

        return $next($request);
    }
}
