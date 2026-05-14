<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function laporan(Request $request)
    {
        if ($request->session()->get('auth.role') !== 'admin') {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $format = $request->query('format', 'pdf');
        $start_date = (string) $request->query('start_date', '');
        $end_date = (string) $request->query('end_date', '');

        $isExcel = in_array($format, ['excel', 'xlsx'], true);

        if ($start_date && $end_date) {
            $startTs = $start_date.'T00:00:00.000Z';
            $endTs = $end_date.'T23:59:59.999Z';
            $rows = DB::table('diagnosa')
                ->where('tanggal_diagnosa', '>=', $startTs)
                ->where('tanggal_diagnosa', '<=', $endTs)
                ->orderByDesc('tanggal_diagnosa')
                ->get();
        } else {
            $rows = DB::table('diagnosa')->orderByDesc('tanggal_diagnosa')->get();
        }

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

        $tableBody = [];
        foreach ($rows as $i => $r) {
            $tableBody[] = [
                (string) ($i + 1),
                format_date_id((string) $r->tanggal_diagnosa),
                $namaUser[$r->id_user] ?? '—',
                $r->hasil_penyakit ? ($namaPenyakit[$r->hasil_penyakit] ?? $r->hasil_penyakit) : '—',
                $r->confidence !== null ? number_format((float) $r->confidence * 100, 2).'%' : '—',
            ];
        }

        if ($isExcel) {
            $sheetData = array_merge(
                [['No', 'Tanggal', 'Nama User', 'Hasil Diagnosa', 'Kecocokan']],
                $tableBody
            );
            $spreadsheet = new Spreadsheet;
            $spreadsheet->getActiveSheet()->fromArray($sheetData);
            $writer = new Xlsx($spreadsheet);
            $tmp = tempnam(sys_get_temp_dir(), 'xlsx');
            $writer->save($tmp);
            $content = file_get_contents($tmp);
            @unlink($tmp);

            return response($content, 200, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="laporan-diagnosa.xlsx"',
            ]);
        }

        $pdf = Pdf::loadView('exports.laporan-pdf', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'rows' => $tableBody,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-diagnosa.pdf');
    }
}
