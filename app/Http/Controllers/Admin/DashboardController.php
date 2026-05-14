<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $penyakit = (int) DB::table('penyakit')->count();
        $gejala = (int) DB::table('gejala')->count();
        $users = (int) DB::table('users')->where('role', 'user')->count();
        $diagnosa = (int) DB::table('diagnosa')->count();
        $relasi = (int) DB::table('relasi')->count();
        $distinctKerusakan = (int) DB::table('diagnosa')
            ->whereNotNull('hasil_penyakit')
            ->selectRaw('count(distinct hasil_penyakit) as c')
            ->value('c');

        $recent = DB::table('diagnosa')
            ->orderByDesc('tanggal_diagnosa')
            ->limit(5)
            ->get();

        $userIds = $recent->pluck('id_user')->unique()->filter()->values()->all();
        $namaUser = [];
        if ($userIds !== []) {
            $namaUser = DB::table('users')->whereIn('id', $userIds)->pluck('nama_lengkap', 'id')->all();
        }

        $kodes = $recent->pluck('hasil_penyakit')->filter()->unique()->values()->all();
        $namaPenyakit = [];
        if ($kodes !== []) {
            $namaPenyakit = DB::table('penyakit')->whereIn('kode_penyakit', $kodes)->pluck('nama_penyakit', 'kode_penyakit')->all();
        }

        $chartLabels = [];
        $chartSeries = [];
        $today = Carbon::now();
        for ($i = 6; $i >= 0; $i--) {
            $day = (clone $today)->subDays($i)->startOfDay();
            $chartLabels[] = $day->format('d/m');
            $chartSeries[] = (int) DB::table('diagnosa')
                ->whereDate('tanggal_diagnosa', $day->format('Y-m-d'))
                ->count();
        }

        $donut = ['ringan' => 0, 'sedang' => 0, 'berat' => 0];
        foreach (DB::table('diagnosa')->select('confidence')->get() as $row) {
            $b = diagnosis_tingkat_bucket($row->confidence !== null ? (float) $row->confidence : null);
            $donut[$b]++;
        }

        $masterPreview = DB::table('penyakit')->orderBy('kode_penyakit')->limit(4)->get();

        return view('admin.dashboard', compact(
            'penyakit',
            'gejala',
            'users',
            'diagnosa',
            'relasi',
            'distinctKerusakan',
            'recent',
            'namaUser',
            'namaPenyakit',
            'chartLabels',
            'chartSeries',
            'donut',
            'masterPreview',
        ));
    }
}
