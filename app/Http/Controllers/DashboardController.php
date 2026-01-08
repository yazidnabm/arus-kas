<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ===============================
        // RINGKASAN
        // ===============================
        $totalMasuk  = DB::table('kas_masuk')->sum('jumlah');
        $totalKeluar = DB::table('kas_keluar')->sum('jumlah');

        $saldo = $totalMasuk - $totalKeluar;

        $totalTransaksi =
            DB::table('kas_masuk')->count() +
            DB::table('kas_keluar')->count();

        // ===============================
        // DATA GRAFIK KAS MASUK
        // ===============================
        $kasMasukChart = DB::table('kas_masuk')
            ->select('tanggal', DB::raw('SUM(jumlah) as total'))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // ===============================
        // DATA GRAFIK KAS KELUAR
        // ===============================
        $kasKeluarChart = DB::table('kas_keluar')
            ->select('tanggal', DB::raw('SUM(jumlah) as total'))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // ===============================
        // KIRIM KE VIEW
        // ===============================
        return view('dashboard.index', compact(
            'saldo',
            'totalMasuk',
            'totalKeluar',
            'totalTransaksi',
            'kasMasukChart',
            'kasKeluarChart'
        ));
    }
}
