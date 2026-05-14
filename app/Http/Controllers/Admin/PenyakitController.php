<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyakitController extends Controller
{
    public function index(Request $request)
    {
        $rows = DB::table('penyakit')->orderBy('kode_penyakit')->get();
        $editing = $request->query('edit')
            ? $rows->firstWhere('kode_penyakit', $request->query('edit'))
            : null;

        return view('admin.penyakit.index', [
            'rows' => $rows,
            'editing' => $editing,
            'success' => $request->query('success'),
            'notice' => $request->query('notice'),
            'error' => $request->query('error'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_penyakit' => 'required|string|max:50',
            'nama_penyakit' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'solusi' => 'nullable|string',
            'pencegahan' => 'nullable|string',
        ]);

        try {
            DB::table('penyakit')->insert([
                'kode_penyakit' => trim($request->input('kode_penyakit')),
                'nama_penyakit' => trim($request->input('nama_penyakit')),
                'deskripsi' => $request->input('deskripsi'),
                'solusi' => $request->input('solusi'),
                'pencegahan' => $request->input('pencegahan'),
            ]);
        } catch (\Throwable $e) {
            $msg = str_contains($e->getMessage(), 'duplicate') || str_contains($e->getMessage(), 'unique')
                ? 'Kode kerusakan sudah ada. Gunakan kode lain atau edit data yang sudah tersimpan.'
                : 'Gagal menyimpan data.';

            return redirect('/admin/penyakit?error='.urlencode($msg));
        }

        return redirect('/admin/penyakit?success=1');
    }

    public function update(Request $request)
    {
        $request->validate([
            'kode_penyakit' => 'required|string|max:50',
            'nama_penyakit' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'solusi' => 'nullable|string',
            'pencegahan' => 'nullable|string',
        ]);

        DB::table('penyakit')
            ->where('kode_penyakit', trim($request->input('kode_penyakit')))
            ->update([
                'nama_penyakit' => trim($request->input('nama_penyakit')),
                'deskripsi' => $request->input('deskripsi'),
                'solusi' => $request->input('solusi'),
                'pencegahan' => $request->input('pencegahan'),
            ]);

        return redirect('/admin/penyakit?success=1');
    }

    public function destroy(Request $request)
    {
        $kode = trim((string) $request->input('kode_penyakit'));
        DB::table('penyakit')->where('kode_penyakit', $kode)->delete();

        return redirect('/admin/penyakit?notice='.urlencode("Data kerusakan {$kode} berhasil dihapus."));
    }
}
