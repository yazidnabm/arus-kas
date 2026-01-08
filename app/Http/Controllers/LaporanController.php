<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai   = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        $kasMasuk = DB::table('kas_masuk')
            ->when($tanggalMulai, fn ($q) => $q->whereDate('tanggal', '>=', $tanggalMulai))
            ->when($tanggalSelesai, fn ($q) => $q->whereDate('tanggal', '<=', $tanggalSelesai))
            ->orderBy('tanggal', 'asc')
            ->get();

        $kasKeluar = DB::table('kas_keluar')
            ->when($tanggalMulai, fn ($q) => $q->whereDate('tanggal', '>=', $tanggalMulai))
            ->when($tanggalSelesai, fn ($q) => $q->whereDate('tanggal', '<=', $tanggalSelesai))
            ->orderBy('tanggal', 'asc')
            ->get();

        $totalMasuk  = $kasMasuk->sum('jumlah');
        $totalKeluar = $kasKeluar->sum('jumlah');
        $saldo       = $totalMasuk - $totalKeluar;

        return view('laporan.index', compact(
            'kasMasuk',
            'kasKeluar',
            'totalMasuk',
            'totalKeluar',
            'saldo',
            'tanggalMulai',
            'tanggalSelesai'
        ));
    }

    // ✅ EXPORT PDF
    public function exportPdf(Request $request)
    {
        $tanggalMulai   = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        $kasMasuk = DB::table('kas_masuk')
            ->when($tanggalMulai, fn ($q) => $q->whereDate('tanggal', '>=', $tanggalMulai))
            ->when($tanggalSelesai, fn ($q) => $q->whereDate('tanggal', '<=', $tanggalSelesai))
            ->orderBy('tanggal', 'asc')
            ->get();

        $kasKeluar = DB::table('kas_keluar')
            ->when($tanggalMulai, fn ($q) => $q->whereDate('tanggal', '>=', $tanggalMulai))
            ->when($tanggalSelesai, fn ($q) => $q->whereDate('tanggal', '<=', $tanggalSelesai))
            ->orderBy('tanggal', 'asc')
            ->get();

        $totalMasuk  = $kasMasuk->sum('jumlah');
        $totalKeluar = $kasKeluar->sum('jumlah');
        $saldo       = $totalMasuk - $totalKeluar;

        $pdf = Pdf::loadView('laporan.pdf', compact(
            'kasMasuk',
            'kasKeluar',
            'totalMasuk',
            'totalKeluar',
            'saldo',
            'tanggalMulai',
            'tanggalSelesai'
        ))->setPaper('A4', 'portrait');

        return $pdf->download('laporan-arus-kas.pdf');
    }
}
