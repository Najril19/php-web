@extends('layouts.dashboard')
@section('title', 'Pengaturan')
@section('content')
<div class="mx-auto max-w-lg space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Pengaturan akun</h1>
        <p class="mt-1 text-sm text-slate-500">Profil dan keamanan masuk.</p>
    </div>
    @if (request('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">Profil diperbarui.</div>
    @endif
    @if (request('error') || session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-900">{{ request('error') ?? session('error') }}</div>
    @endif
    <form method="post" action="/profile" class="space-y-5 rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        @csrf
        <div>
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Nama lengkap</label>
            <input name="nama_lengkap" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/15" value="{{ old('nama_lengkap', $user->nama_lengkap) }}">
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
            <input type="email" name="email" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/15" value="{{ old('email', $user->email) }}">
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Password baru <span class="font-normal text-slate-400">(opsional)</span></label>
            <input type="password" name="password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/15">
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-medium text-slate-700">Password lama <span class="font-normal text-slate-400">(wajib jika ganti password)</span></label>
            <input type="password" name="current_password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/15">
        </div>
        <button type="submit" class="w-full rounded-xl bg-brand-600 py-3 text-sm font-semibold text-white shadow-md hover:bg-brand-700">Simpan perubahan</button>
    </form>
</div>
@endsection
