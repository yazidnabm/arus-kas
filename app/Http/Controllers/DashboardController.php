<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMasuk  = DB::table('kas_masuk')->sum('jumlah');
        $totalKeluar = DB::table('kas_keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;
        $totalTransaksi = DB::table('kas_masuk')->count() + DB::table('kas_keluar')->count();

        $mingguanMasuk = DB::table('kas_masuk')
            ->select('tanggal', DB::raw('SUM(jumlah) as total'))
            ->where('tanggal', '>=', Carbon::now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $mingguanKeluar = DB::table('kas_keluar')
            ->select('tanggal', DB::raw('SUM(jumlah) as total'))
            ->where('tanggal', '>=', Carbon::now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $bulananMasuk = DB::table('kas_masuk')
            ->select(DB::raw('MONTHNAME(tanggal) as bulan'), DB::raw('SUM(jumlah) as total'))
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw('MONTH(tanggal)'), 'bulan')
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->get();

        $bulananKeluar = DB::table('kas_keluar')
            ->select(DB::raw('MONTHNAME(tanggal) as bulan'), DB::raw('SUM(jumlah) as total'))
            ->whereYear('tanggal', date('Y'))
            ->groupBy(DB::raw('MONTH(tanggal)'), 'bulan')
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->get();

        $tahunanMasuk = DB::table('kas_masuk')
            ->select(DB::raw('YEAR(tanggal) as tahun'), DB::raw('SUM(jumlah) as total'))
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $tahunanKeluar = DB::table('kas_keluar')
            ->select(DB::raw('YEAR(tanggal) as tahun'), DB::raw('SUM(jumlah) as total'))
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        return view('dashboard.index', compact(
            'saldo',
            'totalMasuk',
            'totalKeluar',
            'totalTransaksi',
            'mingguanMasuk',
            'mingguanKeluar',
            'bulananMasuk',
            'bulananKeluar',
            'tahunanMasuk',
            'tahunanKeluar'
        ));
    }
}
