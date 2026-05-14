@extends('layouts.guest')
@section('title', 'Masuk | '.config('app.name', 'Sistem Pakar'))
@section('content')
<div class="grid min-h-screen lg:grid-cols-2">
    <div class="relative hidden flex-col justify-between overflow-hidden bg-sidebar px-10 py-12 text-white lg:flex">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/25 via-transparent to-slate-900/80"></div>
        <div class="relative z-10 max-w-md">
            <p class="text-xs font-semibold uppercase tracking-widest text-blue-200/90">Sistem Pakar</p>
            <h1 class="mt-3 text-3xl font-bold leading-tight">Diagnosa Kerusakan</h1>
            <p class="mt-4 text-sm leading-relaxed text-slate-300">
                Bantuan keputusan berbasis aturan dengan metode <strong class="text-white">Forward Chaining</strong> untuk menganalisis gejala dan menyarankan kerusakan yang paling sesuai.
            </p>
        </div>
        <div class="relative z-10 flex flex-1 items-center justify-center py-8">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-10 shadow-2xl backdrop-blur-sm">
                <i class="bi bi-printer-fill text-[8rem] text-blue-300/90 drop-shadow-lg"></i>
            </div>
        </div>
        <p class="relative z-10 text-xs text-slate-500">&copy; {{ date('Y') }} {{ config('app.name', 'Sistem Pakar') }}</p>
    </div>
    <div class="flex flex-col justify-center px-6 py-12 sm:px-10 lg:px-16">
        <div class="mx-auto w-full max-w-md">
            <div class="mb-8 lg:hidden">
                <p class="text-xs font-semibold uppercase tracking-widest text-blue-600">Sistem Pakar</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-900">Masuk</h1>
            </div>
            <h1 class="mb-2 hidden text-2xl font-bold text-slate-900 lg:block">Masuk</h1>
            <p class="mb-8 text-sm text-slate-500">Gunakan email dan password akun Anda.</p>
            @if (!empty($error) || session('error'))
                <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 p-3 text-sm text-amber-900">{{ $error ?? session('error') }}</div>
            @endif
            @if (!empty($registered))
                <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-900">Registrasi berhasil. Silakan masuk.</div>
            @endif
            <form method="post" action="/login" class="space-y-5 rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                @csrf
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" required autocomplete="username"
                           class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none ring-blue-600/20 transition focus:border-blue-500 focus:bg-white focus:ring-4"
                           value="{{ old('email') }}" placeholder="nama@email.com">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" name="password" required autocomplete="current-password"
                           class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none ring-blue-600/20 transition focus:border-blue-500 focus:bg-white focus:ring-4"
                           placeholder="••••••••">
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 py-3 text-sm font-semibold text-white shadow-md shadow-blue-600/25 transition hover:bg-brand-700">
                    Login
                </button>
            </form>
            <p class="mt-6 text-center text-sm text-slate-500">
                Belum punya akun? <a href="/register" class="font-semibold text-brand-600 hover:text-brand-700">Daftar</a>
            </p>
        </div>
    </div>
</div>
@endsection
