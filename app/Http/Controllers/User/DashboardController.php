<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $auth = $request->session()->get('auth');
        $count = 0;
        $rows = collect();
        $dbError = false;
        $gejalaMaster = 0;
        $penyakitMaster = 0;
        $chartLabels = [];
        $chartSeries = [];
        $donut = ['ringan' => 0, 'sedang' => 0, 'berat' => 0];

        try {
            $count = (int) DB::table('diagnosa')->where('id_user', $auth['id'])->count();
            $rows = DB::table('diagnosa')
                ->where('id_user', $auth['id'])
                ->orderByDesc('tanggal_diagnosa')
                ->limit(5)
                ->get();
            $gejalaMaster = (int) DB::table('gejala')->count();
            $penyakitMaster = (int) DB::table('penyakit')->count();

            $today = Carbon::now();
            for ($i = 6; $i >= 0; $i--) {
                $day = (clone $today)->subDays($i)->startOfDay();
                $chartLabels[] = $day->format('d/m');
                $chartSeries[] = (int) DB::table('diagnosa')
                    ->where('id_user', $auth['id'])
                    ->whereDate('tanggal_diagnosa', $day->format('Y-m-d'))
                    ->count();
            }

            foreach (DB::table('diagnosa')->where('id_user', $auth['id'])->select('confidence')->get() as $row) {
                $b = diagnosis_tingkat_bucket($row->confidence !== null ? (float) $row->confidence : null);
                $donut[$b]++;
            }
        } catch (\Throwable $e) {
            $dbError = true;
        }

        $kodes = $rows->pluck('hasil_penyakit')->filter()->unique()->values()->all();
        $namaByKode = [];
        if ($kodes !== []) {
            $namaByKode = DB::table('penyakit')->whereIn('kode_penyakit', $kodes)->pluck('nama_penyakit', 'kode_penyakit')->all();
        }

        return view('user.dashboard', compact(
            'auth',
            'count',
            'rows',
            'namaByKode',
            'dbError',
            'gejalaMaster',
            'penyakitMaster',
            'chartLabels',
            'chartSeries',
            'donut',
        ));
    }
}
