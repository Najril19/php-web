@extends('layouts.dashboard')
@section('title', 'Laporan')
@section('content')
@php
    $d = new \DateTimeImmutable('first day of this month');
    $defaultStart = $d->format('Y-m-d');
    $defaultEnd = (new \DateTimeImmutable)->format('Y-m-d');
@endphp
<div class="mx-auto max-w-3xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Laporan Diagnosa</h1>
        <p class="mt-1 text-[15px] text-slate-600">Unduh rekapitulasi periode tertentu.</p>
    </div>
    <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <p class="mb-6 text-sm text-slate-600">Pilih periode lalu unduh PDF atau Excel.</p>
        <form id="exportForm" method="GET" action="{{ url('/api/admin/export/laporan') }}" class="grid gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Dari tanggal</label>
                <input type="date" name="start_date" value="{{ $defaultStart }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
            </div>
            <div>
                <label class="mb-1 block text-xs font-semibold uppercase text-slate-500">Sampai tanggal</label>
                <input type="date" name="end_date" value="{{ $defaultEnd }}" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/20">
            </div>
            <div class="flex flex-wrap gap-3 sm:col-span-2">
                <button type="submit" name="format" value="pdf" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-700">Unduh PDF</button>
                <button type="submit" name="format" value="excel" class="rounded-xl border border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Unduh Excel</button>
            </div>
        </form>
    </div>
</div>
@endsection
