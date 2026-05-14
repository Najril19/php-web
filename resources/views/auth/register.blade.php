@extends('layouts.guest')
@section('title', 'Daftar | '.config('app.name', 'Sistem Pakar'))
@section('content')
@php
    $printerUrl = asset('images/printer.jpg');
    $brand = config('app.name', 'Sistem Pakar');
    $tagline = config('app.tagline', 'Diagnosa kerusakan printer — Forward Chaining');
@endphp
<div class="flex min-h-screen flex-col bg-white lg:grid lg:min-h-screen lg:grid-cols-2">
    <div class="relative flex min-h-[40vh] flex-shrink-0 flex-col justify-between overflow-hidden bg-[#152238] px-6 py-8 text-white sm:px-10 sm:py-10 lg:min-h-screen lg:px-12 lg:py-14">
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-blue-600/25 via-transparent to-slate-950/90"></div>
        <div class="pointer-events-none absolute inset-0 opacity-[0.14]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='72' height='72' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M36 8l2.5 7h7l5.5-4.5 4.5 4.5-4.5 5.5v7l7 2.5v5l-7 2.5v7l4.5 5.5-4.5 4.5-5.5-4.5h-7l-2.5 7h-5l-2.5-7h-7l-5.5 4.5-4.5-4.5 4.5-5.5v-7l-7-2.5v-5l7-2.5v-7l-4.5-5.5 4.5-4.5 5.5 4.5h7l2.5-7h5z' fill='none' stroke='%23ffffff' stroke-width='0.6'/%3E%3C/svg%3E&quot;); background-size: 72px 72px;"></div>
        <div class="relative z-10 max-w-lg">
            <p class="text-xl font-bold uppercase tracking-[0.12em] text-white sm:text-2xl">Sistem Pakar</p>
            <h1 class="mt-3 text-2xl font-bold leading-tight sm:text-3xl">Buat akun pengguna</h1>
            <p class="mt-3 text-[15px] leading-relaxed text-slate-200/95">{{ $tagline }}</p>
            <p class="mt-2 text-sm text-blue-200/80">{{ $brand }}</p>
        </div>
        <div class="relative z-10 flex flex-1 items-center justify-center py-6">
            <div class="rounded-3xl border border-white/10 bg-white/[0.07] p-8 shadow-2xl backdrop-blur-sm sm:p-10">
                <img src="{{ $printerUrl }}" alt="Printer" class="mx-auto h-auto w-[min(88vw,220px)] object-contain drop-shadow-2xl" width="260" height="260" decoding="async">
            </div>
        </div>
        <p class="relative z-10 text-center text-sm text-slate-300/90">&copy; {{ date('Y') }} {{ $brand }}</p>
    </div>
    <div class="flex flex-1 flex-col justify-center px-5 py-10 sm:px-10 lg:px-14">
        <div class="mx-auto w-full max-w-md">
            <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Daftar</h1>
            <p class="mt-2 text-[15px] text-slate-500">Lengkapi data untuk mulai menggunakan diagnosa.</p>
            @if (!empty($error) || session('error'))
                <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-3.5 text-sm text-red-950">{{ $error ?? session('error') }}</div>
            @endif
            <form method="post" action="/register" class="mt-8 space-y-4 rounded-2xl border border-slate-200/90 bg-white p-7 shadow-[0_8px_30px_rgb(0,0,0,0.06)] sm:p-8">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-800">Nama lengkap</label>
                    <input name="nama_lengkap" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-[15px] outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/15" value="{{ old('nama_lengkap') }}">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-800">Email</label>
                    <input type="email" name="email" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-[15px] outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/15" value="{{ old('email') }}" placeholder="nama@email.com">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-800">Password</label>
                    <input type="password" name="password" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-[15px] outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/15">
                </div>
                <button type="submit" class="w-full rounded-xl bg-brand-600 py-3.5 text-sm font-bold text-white shadow-lg shadow-blue-600/25 hover:bg-brand-700">Daftar</button>
            </form>
            <p class="mt-6 text-center text-sm text-slate-500">Sudah punya akun? <a href="/login" class="font-semibold text-brand-600 hover:text-brand-700">Masuk</a></p>
        </div>
    </div>
</div>
@endsection
