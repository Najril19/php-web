@extends('layouts.guest')
@section('title', 'Masuk | '.config('app.name', 'Sistem Pakar'))
@section('content')
@php
    $printerUrl = asset('images/printer.jpg');
    $brand = config('app.name', 'Sistem Pakar');
    $tagline = config('app.tagline', 'Diagnosa Kerusakan Printer pada Fotocopy Berkah Andirra');
@endphp
{{-- Split 50/50 desktop; mobile: biru atas, putih bawah — layout seperti referensi --}}
<div class="grid min-h-screen grid-cols-1 bg-white lg:grid-cols-2">
    {{-- Panel kiri: biru gelap, teks & printer rata tengah --}}
    <div class="relative flex min-h-0 flex-col items-center justify-center overflow-hidden bg-[#1a2b4b] px-6 py-10 text-center text-white sm:px-10 sm:py-12 lg:min-h-screen lg:px-12 lg:py-8">
        <div class="pointer-events-none absolute inset-0 opacity-30" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='56' height='56' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M28 6l2 6h6l5-4 4 4-4 5v6l6 2v4l-6 2v6l4 5-4 4-5-4h-6l-2 6h-4l-2-6h-6l-5 4-4-4 4-5v-6l-6-2v-4l6-2v-6l-4-5 4-4 5 4h6l2-6h4z' fill='none' stroke='%23ffffff' stroke-width='0.45' opacity='0.35'/%3E%3C/svg%3E&quot;); background-size: 56px 56px;"></div>
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-blue-600/10 via-transparent to-black/20"></div>

        <div class="relative z-10 flex w-full max-w-md flex-col items-center gap-7 sm:gap-8">
            <header class="w-full space-y-4">
                <h1 class="text-3xl font-bold uppercase leading-tight tracking-wide text-white sm:text-4xl md:text-[2.75rem] md:leading-[1.1]">
                    Sistem Pakar
                </h1>
                <p class="text-base font-normal leading-relaxed text-white sm:text-lg md:text-[1.125rem]">
                    {{ $tagline }}
                </p>
            </header>

            <div class="flex w-full justify-center px-2">
                <img src="{{ $printerUrl }}" alt="Printer"
                     class="h-auto w-full max-w-[260px] object-contain drop-shadow-[0_12px_32px_rgba(0,0,0,0.35)] mix-blend-multiply contrast-[1.06] brightness-[1.02] sm:max-w-[300px]"
                     width="320" height="320" decoding="async">
            </div>

            <p class="text-base font-medium text-white sm:text-lg">Metode Forward Chaining</p>
        </div>
    </div>

    {{-- Panel kanan: putih, judul + form + copyright --}}
    <div class="relative flex min-h-0 flex-col bg-white lg:min-h-screen lg:flex lg:flex-col">
        <div class="flex flex-1 flex-col justify-center px-6 py-10 sm:px-12 sm:py-12 lg:px-16 lg:py-10">
            <div class="mx-auto w-full max-w-[22rem]">
                <h2 class="text-2xl font-bold tracking-tight text-[#1a2b4b] sm:text-3xl">Selamat Datang</h2>
                <p class="mt-2 text-sm leading-relaxed text-slate-500 sm:text-base">Silakan login untuk masuk ke sistem</p>

                @if (!empty($error) || session('error'))
                    <div class="mt-5 rounded-lg border border-amber-200 bg-amber-50 p-3 text-sm text-amber-900">{{ $error ?? session('error') }}</div>
                @endif
                @if (!empty($registered))
                    <div class="mt-5 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-900">Registrasi berhasil. Silakan masuk.</div>
                @endif

                <form method="post" action="/login" class="mt-8 space-y-5 rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7" id="form-login">
                    @csrf
                    <div>
                        <label class="mb-1.5 block text-sm font-bold text-slate-900">Username</label>
                        <input type="email" name="email" required autocomplete="username"
                               class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20"
                               value="{{ old('email') }}" placeholder="Masukkan username">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-bold text-slate-900">Password</label>
                        <div class="relative">
                            <input id="login-password" type="password" name="password" required autocomplete="current-password"
                                   class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-3.5 pr-11 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20"
                                   placeholder="Masukkan password">
                            <button type="button" id="login-password-toggle" class="absolute right-1.5 top-1/2 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-md text-slate-500 hover:bg-slate-100 hover:text-slate-800" aria-label="Tampilkan password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-[#2563eb] py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#1d4ed8]">
                        Login
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-500">
                    Belum punya akun? <a href="/register" class="font-semibold text-[#2563eb] hover:underline">Daftar</a>
                </p>
            </div>
        </div>

        <p class="mt-auto pb-6 text-center text-xs text-slate-400 sm:pb-8">&copy; {{ date('Y') }} {{ $brand }}</p>
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
