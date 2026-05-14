@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
@php $tag = config('app.tagline', ''); @endphp
<div class="mx-auto max-w-7xl space-y-6 sm:space-y-8">
    <div class="flex flex-col gap-2 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Dashboard</h1>
            <p class="mt-1 max-w-3xl text-[15px] leading-relaxed text-slate-600">{{ $tag }}</p>
            <p class="mt-2 text-sm font-medium text-slate-500">Halo, <span class="text-slate-800">{{ $auth['nama_lengkap'] }}</span></p>
        </div>
    </div>
        @if (!empty($dbError))
            <p class="mt-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-2 text-sm text-amber-900">Database belum merespons. Coba refresh beberapa saat lagi.</p>
        @endif
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/35"><i class="bi bi-clipboard-data text-2xl"></i></div>
            <div class="min-w-0">
                <p class="text-2xl font-bold tabular-nums text-slate-900">{{ $count }}</p>
                <p class="mt-0.5 text-xs font-semibold uppercase tracking-wide text-slate-500">Total diagnosa Anda</p>
            </div>
        </div>
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-600/35"><i class="bi bi-clipboard2-pulse text-2xl"></i></div>
            <div class="min-w-0">
                <p class="text-2xl font-bold tabular-nums text-slate-900">{{ $gejalaMaster }}</p>
                <p class="mt-0.5 text-xs font-semibold uppercase tracking-wide text-slate-500">Gejala di basis data</p>
            </div>
        </div>
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500 text-white shadow-lg shadow-amber-500/35"><i class="bi bi-exclamation-octagon text-2xl"></i></div>
            <div class="min-w-0">
                <p class="text-2xl font-bold tabular-nums text-slate-900">{{ $penyakitMaster }}</p>
                <p class="mt-0.5 text-xs font-semibold uppercase tracking-wide text-slate-500">Jenis kerusakan terdata</p>
            </div>
        </div>
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-violet-600 text-white shadow-lg shadow-violet-600/35"><i class="bi bi-diagram-3 text-2xl"></i></div>
            <div class="min-w-0">
                <p class="text-sm font-bold leading-snug text-slate-800">Forward chaining</p>
                <p class="mt-1 text-xs font-medium text-slate-500">Gejala → kesimpulan kerusakan</p>
            </div>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-[#152238]">Informasi sistem</h2>
            <p class="mt-3 text-[15px] leading-relaxed text-slate-600">
                Pilih gejala yang Anda amati pada printer. Sistem mencocokkan dengan basis pengetahuan (relasi gejala–kerusakan) dan menampilkan hasil beserta tingkat kepercayaan.
            </p>
            <div class="mt-6 flex flex-col items-center justify-center gap-4 rounded-2xl bg-slate-50/90 px-6 py-8 sm:flex-row sm:py-7">
                <img src="{{ asset('images/printer.jpg') }}" alt="" class="h-28 w-auto max-w-[200px] shrink-0 object-contain sm:h-32" width="200" height="200" decoding="async">
                <p class="max-w-sm text-center text-[14px] leading-relaxed text-slate-600 sm:text-left">Gunakan menu <span class="font-semibold text-slate-800">Diagnosa Kerusakan</span> untuk memulai. Riwayat hasil tersimpan otomatis.</p>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-[#152238]">Riwayat terbaru</h2>
            <div class="mt-4 overflow-x-auto rounded-xl border border-slate-100">
                <table class="w-full min-w-[480px] text-sm">
                    <thead class="bg-slate-100/90 text-left text-xs font-bold uppercase tracking-wide text-slate-600">
                        <tr><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3">Hasil</th><th class="px-4 py-3">%</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $r)
                            <tr class="border-t border-slate-100 odd:bg-white even:bg-slate-50/80">
                                <td class="px-4 py-3 text-slate-600">{{ format_date_id($r->tanggal_diagnosa) }}</td>
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $r->hasil_penyakit ? ($namaByKode[$r->hasil_penyakit] ?? $r->hasil_penyakit) : '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $r->confidence !== null ? number_format($r->confidence * 100, 1) : '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-4 py-8 text-center text-slate-500">Belum ada diagnosa</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <a href="/user/diagnosa" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700">Mulai diagnosa <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-[#152238]">Statistik diagnosa (7 hari)</h2>
            <p class="text-xs text-slate-500">Jumlah diagnosa per hari — akun Anda</p>
            <div class="mt-4 h-64"><canvas id="chartLineUser"></canvas></div>
        </div>
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-[#152238]">Berdasarkan tingkat (kepercayaan)</h2>
            <p class="text-xs text-slate-500">Ringan &lt;50% · Sedang 50–79% · Berat ≥80%</p>
            <div class="mx-auto mt-2 h-56 max-w-xs"><canvas id="chartDonutUser"></canvas></div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    const labels = @json($chartLabels);
    const series = @json($chartSeries);
    const donut = @json($donut);
    const totalD = donut.ringan + donut.sedang + donut.berat;
    if (typeof Chart !== 'undefined' && document.getElementById('chartLineUser')) {
        new Chart(document.getElementById('chartLineUser'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Diagnosa',
                    data: series,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.12)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                },
            },
        });
    }
    if (document.getElementById('chartDonutUser') && typeof Chart !== 'undefined') {
        new Chart(document.getElementById('chartDonutUser'), {
            type: 'doughnut',
            data: {
                labels: ['Ringan', 'Sedang', 'Berat'],
                datasets: [{
                    data: totalD ? [donut.ringan, donut.sedang, donut.berat] : [1],
                    backgroundColor: totalD ? ['#22c55e', '#f59e0b', '#ef4444'] : ['#e2e8f0'],
                    borderWidth: 0,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } },
                },
            },
        });
    }
</script>
@endpush
@endsection
