@extends('layouts.guest')
@section('title', 'Masuk | '.config('app.name', 'Sistem Pakar'))
@section('content')
@php
    $printerUrl = asset('images/printer.png');
    $brand = config('app.name', 'Sistem Pakar');
    $tagline = config('app.tagline', 'Diagnosa Kerusakan Printer pada Fotocopy Berkah Andirra');
@endphp
{{-- Split 50/50 desktop; mobile: biru atas, putih bawah — layout seperti referensi --}}
<div class="grid min-h-screen grid-cols-1 bg-white lg:grid-cols-2">
    {{-- Panel kiri: biru gelap, teks & printer rata tengah --}}
    <div class="relative flex min-h-0 flex-col items-center justify-center overflow-hidden bg-[#1a2b4b] px-8 py-12 text-white sm:px-12 sm:py-16 lg:min-h-screen lg:px-16 lg:py-12">
        <div class="pointer-events-none absolute inset-0 opacity-30" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='56' height='56' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M28 6l2 6h6l5-4 4 4-4 5v6l6 2v4l-6 2v6l4 5-4 4-5-4h-6l-2 6h-4l-2-6h-6l-5 4-4-4 4-5v-6l-6-2v-4l6-2v-6l-4-5 4-4 5 4h6l2-6h4z' fill='none' stroke='%23ffffff' stroke-width='0.45' opacity='0.35'/%3E%3C/svg%3E&quot;); background-size: 56px 56px;"></div>
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-blue-600/10 via-transparent to-black/20"></div>
        {{-- Gear icon top-left --}}
        <div class="absolute left-4 top-4 text-white/20 sm:left-6 sm:top-6 lg:left-8 lg:top-8">
            <svg class="h-16 w-16 sm:h-20 sm:w-20 lg:h-24 lg:w-24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 15.5A3.5 3.5 0 0 1 8.5 12 3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5 3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97 0-.33-.03-.66-.07-1l2.11-1.63c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.31-.61-.22l-2.49 1c-.52-.39-1.06-.73-1.69-.98l-.37-2.65A.506.506 0 0 0 14 2h-4c-.25 0-.46.18-.5.42l-.37 2.65c-.63.25-1.17.59-1.69.98l-2.49-1c-.22-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64L4.57 11c-.04.34-.07.67-.07 1 0 .33.03.65.07.97l-2.11 1.66c-.19.15-.25.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1.01c.52.4 1.06.74 1.69.99l.37 2.65c.04.24.25.42.5.42h4c.25 0 .46-.18.5-.42l.37-2.65c.63-.26 1.17-.59 1.69-.99l2.49 1.01c.22.08.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.66Z"/>
            </svg>
        </div>
        {{-- Gear icon bottom-right --}}
        <div class="absolute right-4 bottom-4 text-white/20 sm:right-6 sm:bottom-6 lg:right-8 lg:bottom-8">
            <svg class="h-16 w-16 sm:h-20 sm:w-20 lg:h-24 lg:w-24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 15.5A3.5 3.5 0 0 1 8.5 12 3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5 3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97 0-.33-.03-.66-.07-1l2.11-1.63c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.31-.61-.22l-2.49 1c-.52-.39-1.06-.73-1.69-.98l-.37-2.65A.506.506 0 0 0 14 2h-4c-.25 0-.46.18-.5.42l-.37 2.65c-.63.25-1.17.59-1.69.98l-2.49-1c-.22-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64L4.57 11c-.04.34-.07.67-.07 1 0 .33.03.65.07.97l-2.11 1.66c-.19.15-.25.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1.01c.52.4 1.06.74 1.69.99l.37 2.65c.04.24.25.42.5.42h4c.25 0 .46-.18.5-.42l.37-2.65c.63-.26 1.17-.59 1.69-.99l2.49 1.01c.22.08.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.66Z"/>
            </svg>
        </div>

        <div class="relative z-10 flex w-full max-w-lg flex-col items-center gap-8 sm:gap-10">
            <header class="w-full space-y-3 text-center">
                <h1 class="text-4xl font-bold uppercase leading-tight tracking-wide text-white sm:text-5xl md:text-6xl">
                    Sistem Pakar
                </h1>
                <p class="text-lg font-normal leading-relaxed text-white/90 sm:text-xl md:text-2xl">
                    {{ $tagline }}
                </p>
            </header>

            <div class="flex w-full justify-center px-4">
                <img src="{{ $printerUrl }}" alt="Printer"
                     class="h-auto w-full max-w-[280px] object-contain drop-shadow-[0_16px_40px_rgba(0,0,0,0.4)] sm:max-w-[320px] md:max-w-[360px]"
                     width="400" height="400" decoding="async">
            </div>

            <p class="text-lg font-semibold text-white sm:text-xl md:text-2xl">Metode Forward Chaining</p>
        </div>
    </div>

    {{-- Panel kanan: putih, judul + form + copyright --}}
    <div class="relative flex min-h-0 flex-col bg-white lg:min-h-screen lg:flex lg:flex-col">
        <div class="flex flex-1 flex-col justify-center px-8 py-12 sm:px-12 sm:py-16 lg:px-16 lg:py-12">
            <div class="mx-auto w-full max-w-md">
                <h2 class="text-3xl font-bold tracking-tight text-[#1a2b4b] sm:text-4xl">Selamat Datang</h2>
                <p class="mt-3 text-base leading-relaxed text-slate-600 sm:text-lg">Silakan login untuk masuk ke sistem</p>

                @if (!empty($error) || session('error'))
                    <div class="mt-5 rounded-lg border border-amber-200 bg-amber-50 p-3 text-sm text-amber-900">{{ $error ?? session('error') }}</div>
                @endif
                @if (!empty($registered))
                    <div class="mt-5 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-900">Registrasi berhasil. Silakan masuk.</div>
                @endif

                <form method="post" action="/login" class="mt-8 space-y-6" id="form-login">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Username</label>
                        <input type="email" name="email" required autocomplete="username"
                               class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#1a2b4b] focus:ring-2 focus:ring-[#1a2b4b]/20"
                               value="{{ old('email') }}" placeholder="Masukkan username">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                        <div class="relative">
                            <input id="login-password" type="password" name="password" required autocomplete="current-password"
                                   class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#1a2b4b] focus:ring-2 focus:ring-[#1a2b4b]/20"
                                   placeholder="Masukkan password">
                            <button type="button" id="login-password-toggle" class="absolute right-3 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-md text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Tampilkan password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-[#1a2b4b] py-3.5 text-sm font-semibold text-white shadow-md transition hover:bg-[#0f1a2e]">
                        Login
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-600">
                    Belum punya akun? <a href="/register" class="font-semibold text-[#1a2b4b] hover:underline">Daftar</a>
                </p>
            </div>
        </div>

        <p class="mt-auto pb-8 text-center text-sm text-slate-500 sm:pb-10">&copy; 2024 Fotocopy Berkah Andirra</p>
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
