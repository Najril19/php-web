<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $rows = DB::table('diagnosa')->orderByDesc('tanggal_diagnosa')->get();

        $userIds = $rows->pluck('id_user')->unique()->filter()->values()->all();
        $namaUser = [];
        if ($userIds !== []) {
            $namaUser = DB::table('users')->whereIn('id', $userIds)->pluck('nama_lengkap', 'id')->all();
        }

        $kodes = $rows->pluck('hasil_penyakit')->filter()->unique()->values()->all();
        $namaPenyakit = [];
        if ($kodes !== []) {
            $namaPenyakit = DB::table('penyakit')->whereIn('kode_penyakit', $kodes)->pluck('nama_penyakit', 'kode_penyakit')->all();
        }

        return view('admin.riwayat.index', [
            'rows' => $rows,
            'namaUser' => $namaUser,
            'namaPenyakit' => $namaPenyakit,
            'notice' => $request->query('notice'),
        ]);
    }

    public function destroy(Request $request)
    {
        $id = (int) $request->input('id');
        $t = DB::table('diagnosa')->where('id', $id)->value('tanggal_diagnosa');
        DB::table('diagnosa')->where('id', $id)->delete();
        $when = $t ? format_date_id((string) $t) : "#{$id}";

        return redirect('/admin/riwayat?notice='.urlencode("Diagnosa #{$id} ({$when}) berhasil dihapus dari riwayat."));
    }
}
