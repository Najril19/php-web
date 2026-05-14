<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    public function index()
    {
        return response()->json(['ok' => true]);
    }

    public function db()
    {
        $configured = (bool) trim((string) env('DATABASE_URL', '')) || (bool) env('DB_DATABASE');

        if (! $configured) {
            return response()->json([
                'ok' => false,
                'configured' => false,
                'connectOk' => false,
                'migrationOk' => false,
                'hint' => 'Set DB_* or DATABASE_URL in .env',
            ], 503);
        }

        try {
            DB::select('select 1');
        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'configured' => true,
                'connectOk' => false,
                'migrationOk' => false,
                'hint' => $e->getMessage(),
            ], 503);
        }

        try {
            DB::table('users')->limit(1)->count();
        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'configured' => true,
                'connectOk' => true,
                'migrationOk' => false,
                'migrationError' => $e->getMessage(),
            ], 503);
        }

        return response()->json([
            'ok' => true,
            'configured' => true,
            'connectOk' => true,
            'migrationOk' => true,
        ]);
    }
}
