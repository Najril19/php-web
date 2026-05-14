<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (! $request->session()->has('auth')) {
            return redirect('/login');
        }

        $role = $request->session()->get('auth.role');

        return redirect($role === 'admin' ? '/admin/dashboard' : '/user/dashboard');
    }
}
