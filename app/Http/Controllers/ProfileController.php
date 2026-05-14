<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $auth = $request->session()->get('auth');

        return view('profile.show', [
            'user' => DB::table('users')->where('id', $auth['id'])->first(),
            'success' => $request->query('success'),
            'error' => $request->query('error'),
        ]);
    }

    public function update(Request $request)
    {
        $auth = $request->session()->get('auth');
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string',
            'current_password' => 'nullable|string',
        ]);

        $user = DB::table('users')->where('id', $auth['id'])->first();
        if (! $user) {
            return redirect('/login');
        }

        $password = $request->input('password', '');
        if ($password !== '') {
            if (! $request->filled('current_password') || ! Hash::check($request->input('current_password'), $user->password_hash)) {
                return redirect('/profile')->with('error', 'Password lama salah');
            }
            DB::table('users')->where('id', $auth['id'])->update([
                'nama_lengkap' => trim($request->input('nama_lengkap')),
                'email' => strtolower(trim($request->input('email'))),
                'password_hash' => Hash::make($password),
            ]);
        } else {
            DB::table('users')->where('id', $auth['id'])->update([
                'nama_lengkap' => trim($request->input('nama_lengkap')),
                'email' => strtolower(trim($request->input('email'))),
            ]);
        }

        $request->session()->put('auth.nama_lengkap', trim($request->input('nama_lengkap')));
        $request->session()->put('auth.email', strtolower(trim($request->input('email'))));

        return redirect('/profile?success=1');
    }
}
