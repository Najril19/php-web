@php
    $adminNav = [
        ['/admin/dashboard', 'Dashboard', 'bi-speedometer2'],
        ['/admin/riwayat', 'Riwayat Diagnosa', 'bi-clock-history'],
        ['/admin/penyakit', 'Data Kerusakan', 'bi-exclamation-octagon'],
        ['/admin/gejala', 'Data Gejala', 'bi-clipboard2-pulse'],
        ['/admin/relasi', 'Data Rule (Aturan)', 'bi-diagram-3'],
        ['/admin/pengguna', 'Data Pengguna', 'bi-people'],
        ['/admin/laporan', 'Laporan', 'bi-file-earmark-bar-graph'],
        ['/profile', 'Pengaturan', 'bi-gear'],
    ];
    $userNav = [
        ['/user/dashboard', 'Dashboard', 'bi-speedometer2'],
        ['/user/diagnosa', 'Diagnosa Kerusakan', 'bi-search-heart'],
        ['/user/riwayat', 'Riwayat Diagnosa', 'bi-clock-history'],
        ['/profile', 'Pengaturan', 'bi-gear'],
    ];
    $items = $role === 'admin' ? $adminNav : $userNav;
@endphp
<aside class="flex w-64 shrink-0 flex-col border-r border-slate-700/80 bg-sidebar text-slate-200 shadow-xl print:hidden md:w-72">
    <div class="border-b border-slate-600/60 px-5 py-6">
        <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-blue-300/90">Sistem Pakar</p>
        <p class="mt-1 text-lg font-bold leading-snug text-white">Diagnosa Kerusakan</p>
        <p class="mt-2 text-xs leading-relaxed text-slate-400">Metode <span class="font-semibold text-slate-200">Forward Chaining</span></p>
    </div>
    <nav class="flex-1 space-y-0.5 overflow-y-auto px-3 py-4">
        @foreach ($items as $item)
            @php [$href, $label, $icon] = $item; $path = ltrim($href, '/'); @endphp
            <a href="{{ $href }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
               {{ request()->is($path) || request()->is($path.'/*')
                    ? 'bg-blue-600 text-white shadow-md shadow-blue-900/30'
                    : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg {{ request()->is($path) || request()->is($path.'/*') ? 'bg-white/15' : 'bg-slate-700/50' }}">
                    <i class="bi {{ $icon }} text-lg"></i>
                </span>
                {{ $label }}
            </a>
        @endforeach
    </nav>
    <form action="{{ route('logout') }}" method="post" class="border-t border-slate-600/60 p-4">
        @csrf
        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-500/50 bg-slate-800/40 px-3 py-2.5 text-sm font-medium text-slate-200 transition hover:border-slate-400 hover:bg-slate-700/60">
            <i class="bi bi-box-arrow-right text-lg"></i> Keluar
        </button>
    </form>
</aside>
