<?php

namespace App\Services;

/**
 * Forward chaining — same logic as Next.js `src/lib/diagnosis.ts`.
 */
class DiagnosisService
{
    /**
     * @param  array<int, string>  $selectedGejala
     * @param  array<int, object{ kode_penyakit: string, kode_gejala: string, nama_penyakit: string }>  $relasi
     * @return array<int, array{ kode_penyakit: string, nama_penyakit: string, confidence: float, gejala_cocok: int, total_gejala: int }>
     */
    public static function compute(array $selectedGejala, array $relasi): array
    {
        $penyakit_gejala = [];

        foreach ($relasi as $r) {
            if (! isset($penyakit_gejala[$r->kode_penyakit])) {
                $penyakit_gejala[$r->kode_penyakit] = [
                    'nama' => $r->nama_penyakit,
                    'total_gejala' => 0,
                    'gejala_cocok' => 0,
                ];
            }
            $penyakit_gejala[$r->kode_penyakit]['total_gejala']++;
        }

        foreach ($selectedGejala as $gejala_kode) {
            foreach ($relasi as $r) {
                if ($r->kode_gejala === $gejala_kode) {
                    $penyakit_gejala[$r->kode_penyakit]['gejala_cocok']++;
                }
            }
        }

        $hasil = [];
        foreach ($penyakit_gejala as $kode => $data) {
            $hasil[] = [
                'kode_penyakit' => $kode,
                'nama_penyakit' => $data['nama'],
                'confidence' => $data['total_gejala'] ? ($data['gejala_cocok'] / $data['total_gejala']) : 0.0,
                'gejala_cocok' => $data['gejala_cocok'],
                'total_gejala' => $data['total_gejala'],
            ];
        }

        usort($hasil, fn ($a, $b) => $b['confidence'] <=> $a['confidence']);

        return $hasil;
    }
}
