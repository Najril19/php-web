@extends('layouts.guest')
@section('title', 'Masuk | '.config('app.name', 'Sistem Pakar'))
@section('content')
@php
    $printerUrl = asset('images/printer.jpg');
    $brand = config('app.name', 'Sistem Pakar');
    $tagline = config('app.tagline', 'Diagnosa kerusakan printer — Forward Chaining');
@endphp
<div class="flex min-h-screen flex-col bg-white lg:grid lg:min-h-screen lg:grid-cols-2">
    {{-- Panel kiri / atas mobile: branding --}}
    <div class="relative flex min-h-[44vh] flex-shrink-0 flex-col justify-between overflow-hidden bg-[#152238] px-6 py-8 text-white sm:min-h-[46vh] sm:px-10 sm:py-10 lg:min-h-screen lg:px-12 lg:py-14">
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-blue-600/25 via-transparent to-slate-950/90"></div>
        <div class="pointer-events-none absolute inset-0 opacity-[0.14]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='72' height='72' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M36 8l2.5 7h7l5.5-4.5 4.5 4.5-4.5 5.5v7l7 2.5v5l-7 2.5v7l4.5 5.5-4.5 4.5-5.5-4.5h-7l-2.5 7h-5l-2.5-7h-7l-5.5 4.5-4.5-4.5 4.5-5.5v-7l-7-2.5v-5l7-2.5v-7l-4.5-5.5 4.5-4.5 5.5 4.5h7l2.5-7h5z' fill='none' stroke='%23ffffff' stroke-width='0.6'/%3E%3C/svg%3E&quot;); background-size: 72px 72px;"></div>
        <div class="relative z-10 max-w-lg">
            <p class="text-xl font-bold uppercase tracking-[0.12em] text-white sm:text-2xl">Sistem Pakar</p>
            <p class="mt-3 text-[15px] font-medium leading-relaxed text-slate-200/95 sm:text-base">{{ $tagline }}</p>
            <p class="mt-2 text-sm text-blue-200/80">{{ $brand }}</p>
        </div>
        <div class="relative z-10 flex flex-1 flex-col items-center justify-center py-6 sm:py-10">
            <div class="rounded-3xl border border-white/10 bg-white/[0.07] p-6 shadow-2xl backdrop-blur-sm sm:p-10">
                <img src="{{ $printerUrl }}" alt="Printer" class="mx-auto h-auto w-[min(92vw,240px)] max-w-[280px] object-contain drop-shadow-2xl" width="280" height="280" decoding="async">
            </div>
        </div>
        <p class="relative z-10 text-center text-sm font-medium text-slate-300/90">Metode Forward Chaining</p>
    </div>

    {{-- Form --}}
    <div class="flex flex-1 flex-col justify-center px-5 py-10 sm:px-10 lg:px-14 lg:py-12">
        <div class="mx-auto w-full max-w-md">
            <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Selamat Datang</h1>
            <p class="mt-2 text-[15px] leading-relaxed text-slate-500">Silakan login untuk masuk ke sistem.</p>

            @if (!empty($error) || session('error'))
                <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-3.5 text-sm leading-relaxed text-amber-950">{{ $error ?? session('error') }}</div>
            @endif
            @if (!empty($registered))
                <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 p-3.5 text-sm leading-relaxed text-emerald-950">Registrasi berhasil. Silakan masuk.</div>
            @endif

            <form method="post" action="/login" class="mt-8 space-y-5 rounded-2xl border border-slate-200/90 bg-white p-7 shadow-[0_8px_30px_rgb(0,0,0,0.06)] sm:p-8" id="form-login">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-800">Username / Email</label>
                    <input type="email" name="email" required autocomplete="username"
                           class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-[15px] text-slate-900 outline-none ring-blue-600/15 transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4"
                           value="{{ old('email') }}" placeholder="Masukkan email atau username">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-800">Password</label>
                    <div class="relative">
                        <input id="login-password" type="password" name="password" required autocomplete="current-password"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-4 pr-12 text-[15px] text-slate-900 outline-none ring-blue-600/15 transition focus:border-blue-500 focus:bg-white focus:ring-4"
                               placeholder="Masukkan password">
                        <button type="button" id="login-password-toggle" class="absolute right-2 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100 hover:text-slate-800" aria-label="Tampilkan password">
                            <i class="bi bi-eye text-lg"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-600/25 transition hover:bg-brand-700">
                    Login
                </button>
            </form>

            <p class="mt-8 text-center text-sm text-slate-500">
                Belum punya akun? <a href="/register" class="font-semibold text-brand-600 hover:text-brand-700">Daftar</a>
            </p>
            <p class="mt-10 text-center text-xs text-slate-400">&copy; {{ date('Y') }} {{ $brand }}</p>
        </div>
    </div>
</div>
<script>
    (function () {
        var input = document.getElementById('login-password');
        var btn = document.getElementById('login-password-toggle');
        if (!input || !btn) return;
        btn.addEventListener('click', function () {
            var icon = btn.querySelector('i');
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            if (icon) {
                icon.classList.toggle('bi-eye', !show);
                icon.classList.toggle('bi-eye-slash', show);
            }
            btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
        });
    })();
</script>
@endsection
