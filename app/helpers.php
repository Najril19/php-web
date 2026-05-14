<?php

use Carbon\Carbon;

if (! function_exists('format_date_id')) {
    function format_date_id(?string $iso): string
    {
        if (! $iso) {
            return '—';
        }

        return Carbon::parse($iso)->timezone(config('app.timezone', 'Asia/Jakarta'))->format('d/m/Y, H:i');
    }
}

if (! function_exists('diagnosis_tingkat_label')) {
    /** @param  float|null  $confidence  nilai 0–1 di kolom diagnosa.confidence */
    function diagnosis_tingkat_label(?float $confidence): string
    {
        if ($confidence === null) {
            return 'Ringan';
        }
        $p = (float) $confidence;
        if ($p >= 0.8) {
            return 'Berat';
        }
        if ($p >= 0.5) {
            return 'Sedang';
        }

        return 'Ringan';
    }
}

if (! function_exists('diagnosis_tingkat_bucket')) {
    /** @return 'ringan'|'sedang'|'berat' */
    function diagnosis_tingkat_bucket(?float $confidence): string
    {
        if ($confidence === null) {
            return 'ringan';
        }
        $p = (float) $confidence;
        if ($p >= 0.8) {
            return 'berat';
        }
        if ($p >= 0.5) {
            return 'sedang';
        }

        return 'ringan';
    }
}
