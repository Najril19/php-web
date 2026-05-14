@extends('layouts.dashboard')
@section('title', 'Dashboard Admin')
@section('content')
@php $tag = config('app.tagline', ''); @endphp
<div class="mx-auto max-w-7xl space-y-6 sm:space-y-8">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-[#152238] sm:text-3xl">Dashboard</h1>
        <p class="mt-1 max-w-3xl text-[15px] leading-relaxed text-slate-600">{{ $tag }}</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/35"><i class="bi bi-exclamation-octagon text-2xl"></i></div>
            <div>
                <p class="text-2xl font-bold tabular-nums text-slate-900">{{ $penyakit }}</p>
                <p class="mt-0.5 text-xs font-semibold uppercase tracking-wide text-slate-500">Data kerusakan</p>
            </div>
        </div>
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-600/35"><i class="bi bi-clipboard2-check text-2xl"></i></div>
            <div>
                <p class="text-2xl font-bold tabular-nums text-slate-900">{{ $diagnosa }}</p>
                <p class="mt-0.5 text-xs font-semibold uppercase tracking-wide text-slate-500">Total diagnosa</p>
            </div>
        </div>
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500 text-white shadow-lg shadow-amber-500/35"><i class="bi bi-bug text-2xl"></i></div>
            <div>
                <p class="text-2xl font-bold tabular-nums text-slate-900">{{ $distinctKerusakan }}</p>
                <p class="mt-0.5 text-xs font-semibold uppercase tracking-wide text-slate-500">Kerusakan terdeteksi</p>
            </div>
        </div>
        <div class="flex gap-4 rounded-2xl border border-slate-200/90 bg-white p-5 shadow-[0_4px_24px_rgba(15,23,42,0.06)]">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-violet-600 text-white shadow-lg shadow-violet-600/35"><i class="bi bi-diagram-3 text-2xl"></i></div>
            <div>
                <p class="text-2xl font-bold tabular-nums text-slate-900">{{ $relasi }}</p>
                <p class="mt-0.5 text-xs font-semibold uppercase tracking-wide text-slate-500">Aturan (relasi)</p>
            </div>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-[#152238]">Informasi sistem</h2>
            <p class="mt-3 text-[15px] leading-relaxed text-slate-600">
                Kelola data kerusakan printer, gejala, dan relasi IF–THEN untuk forward chaining. Pantau tren diagnosa dan distribusi tingkat kepercayaan dari seluruh pengguna.
            </p>
            <div class="mt-6 flex flex-col items-center gap-4 rounded-2xl bg-slate-50/90 p-5 sm:flex-row sm:items-center">
                <img src="{{ asset('images/printer.jpg') }}" alt="" class="h-24 w-auto max-w-[180px] shrink-0 object-contain sm:h-28" width="180" height="180" decoding="async">
                <div class="min-w-0 flex-1 text-center text-[14px] leading-relaxed text-slate-600 sm:text-left">
                    <p><span class="font-semibold text-slate-800">{{ $gejala }}</span> gejala terdata · <span class="font-semibold text-slate-800">{{ $users }}</span> pengguna (role user)</p>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-[#152238]">Referensi kerusakan</h2>
            <p class="text-xs text-slate-500">Cuplikan data master</p>
            <ul class="mt-4 space-y-3">
                @forelse ($masterPreview as $p)
                    <li class="flex items-center justify-between gap-3 rounded-xl border border-slate-100 bg-slate-50/80 px-4 py-3">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $p->nama_penyakit }}</p>
                            <p class="font-mono text-xs text-slate-500">{{ $p->kode_penyakit }}</p>
                        </div>
                        <span class="shrink-0 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-800">Terdata</span>
                    </li>
                @empty
                    <li class="text-sm text-slate-500">Belum ada data kerusakan.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-[#152238]">Statistik diagnosa (7 hari)</h2>
            <p class="text-xs text-slate-500">Seluruh pengguna</p>
            <div class="mt-4 h-64"><canvas id="chartLineAdmin"></canvas></div>
        </div>
        <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-7">
            <h2 class="text-lg font-bold tracking-tight text-[#152238]">Diagnosa berdasarkan tingkat</h2>
            <p class="text-xs text-slate-500">Dari nilai confidence</p>
            <div class="mx-auto mt-2 h-56 max-w-xs"><canvas id="chartDonutAdmin"></canvas></div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-[0_4px_24px_rgba(15,23,42,0.06)] sm:p-7">
        <h2 class="text-lg font-bold tracking-tight text-[#152238]">Diagnosa terbaru</h2>
        <div class="mt-4 overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full min-w-[520px] text-sm">
                <thead class="bg-slate-100/90 text-left text-xs font-bold uppercase tracking-wide text-slate-600">
                    <tr><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3">Pengguna</th><th class="px-4 py-3">Hasil</th></tr>
                </thead>
                <tbody>
                    @foreach ($recent as $i => $r)
                        <tr class="border-t border-slate-100 odd:bg-white even:bg-slate-50/80">
                            <td class="px-4 py-3 text-slate-600">{{ format_date_id($r->tanggal_diagnosa) }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $namaUser[$r->id_user] ?? '—' }}</td>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $r->hasil_penyakit ? ($namaPenyakit[$r->hasil_penyakit] ?? $r->hasil_penyakit) : '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script>
    if (typeof Chart === 'undefined') {
        console.warn('Chart.js tidak dimuat');
    } else {
    const labels = @json($chartLabels);
    const series = @json($chartSeries);
    const donut = @json($donut);
    const totalD = donut.ringan + donut.sedang + donut.berat;
    new Chart(document.getElementById('chartLineAdmin'), {
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
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
        },
    });
    new Chart(document.getElementById('chartDonutAdmin'), {
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
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } },
        },
    });
    }
</script>
@endpush
@endsection
