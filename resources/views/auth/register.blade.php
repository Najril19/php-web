@extends('layouts.guest')
@section('title', 'Daftar | '.config('app.name', 'Sistem Pakar'))
@section('content')
<div class="grid min-h-screen lg:grid-cols-2">
    <div class="relative hidden flex-col justify-between overflow-hidden bg-sidebar px-10 py-12 text-white lg:flex">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/25 via-transparent to-slate-900/80"></div>
        <div class="relative z-10 max-w-md">
            <p class="text-xs font-semibold uppercase tracking-widest text-blue-200/90">Sistem Pakar</p>
            <h1 class="mt-3 text-3xl font-bold leading-tight">Buat akun pengguna</h1>
            <p class="mt-4 text-sm leading-relaxed text-slate-300">
                Setelah terdaftar, Anda dapat menjalankan diagnosa kerusakan dan melihat riwayat hasil.
            </p>
        </div>
        <div class="relative z-10 flex flex-1 items-center justify-center py-8">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-10 shadow-2xl backdrop-blur-sm">
                <i class="bi bi-person-plus text-[7rem] text-blue-300/90 drop-shadow-lg"></i>
            </div>
        </div>
        <p class="relative z-10 text-xs text-slate-500">&copy; {{ date('Y') }} {{ config('app.name', 'Sistem Pakar') }}</p>
    </div>
    <div class="flex flex-col justify-center px-6 py-12 sm:px-10 lg:px-16">
        <div class="mx-auto w-full max-w-md">
            <h1 class="mb-2 text-2xl font-bold text-slate-900">Daftar</h1>
            <p class="mb-8 text-sm text-slate-500">Lengkapi data di bawah ini.</p>
            @if (!empty($error) || session('error'))
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-900">{{ $error ?? session('error') }}</div>
            @endif
            <form method="post" action="/register" class="space-y-4 rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                @csrf
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Nama lengkap</label>
                    <input name="nama_lengkap" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-blue-600/20 focus:border-blue-500 focus:bg-white focus:ring-4" value="{{ old('nama_lengkap') }}">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-blue-600/20 focus:border-blue-500 focus:bg-white focus:ring-4" value="{{ old('email') }}">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" name="password" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-blue-600/20 focus:border-blue-500 focus:bg-white focus:ring-4">
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 py-3 text-sm font-semibold text-white shadow-md hover:bg-brand-700">Daftar</button>
            </form>
            <p class="mt-6 text-center text-sm text-slate-500">
                Sudah punya akun? <a href="/login" class="font-semibold text-brand-600 hover:text-brand-700">Masuk</a>
            </p>
        </div>
    </div>
</div>
@endsection
