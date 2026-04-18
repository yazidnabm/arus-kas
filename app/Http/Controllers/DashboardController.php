<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama (Tetap dihitung di awal untuk tampilan Card)
        $totalMasuk  = DB::table('kas_masuk')->sum('jumlah') ?? 0;
        $totalKeluar = DB::table('kas_keluar')->sum('jumlah') ?? 0;
        $saldo = $totalMasuk - $totalKeluar;
        $totalTransaksi = DB::table('kas_masuk')->count() + DB::table('kas_keluar')->count();

        return view('dashboard.index', compact(
            'saldo',
            'totalMasuk',
            'totalKeluar',
            'totalTransaksi'
        ));
    }

    /**
     * Method Khusus API untuk Filter Grafik
     */
    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'mingguan');
        $labels = [];
        $dataMasuk = [];
        $dataKeluar = [];

        if ($type == 'bulanan') {
            // Filter: Per Hari dalam Bulan Tertentu
            $monthYear = $request->get('month', date('Y-m')); // Format: 2024-03
            $year = date('Y', strtotime($monthYear));
            $month = date('m', strtotime($monthYear));

            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $date = $year . '-' . $month . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                $labels[] = $i; // Label: Tanggal 1, 2, 3...
                
                $dataMasuk[] = DB::table('kas_masuk')->whereDate('tanggal', $date)->sum('jumlah') ?? 0;
                $dataKeluar[] = DB::table('kas_keluar')->whereDate('tanggal', $date)->sum('jumlah') ?? 0;
            }
        } 
        elseif ($type == 'tahunan') {
            // Filter: Per Bulan dalam Tahun Tertentu
            $year = $request->get('year', date('Y'));
            $months = [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 
                'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ];
            
            foreach ($months as $index => $m) {
                $labels[] = $m;
                $dataMasuk[] = DB::table('kas_masuk')
                    ->whereYear('tanggal', $year)
                    ->whereMonth('tanggal', $index + 1)
                    ->sum('jumlah') ?? 0;

                $dataKeluar[] = DB::table('kas_keluar')
                    ->whereYear('tanggal', $year)
                    ->whereMonth('tanggal', $index + 1)
                    ->sum('jumlah') ?? 0;
            }
        } 
        else {
            // Default: Mingguan (7 Hari Terakhir dari hari ini)
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $labels[] = Carbon::parse($date)->translatedFormat('d M'); // Contoh: 18 Apr
                
                $dataMasuk[] = DB::table('kas_masuk')->whereDate('tanggal', $date)->sum('jumlah') ?? 0;
                $dataKeluar[] = DB::table('kas_keluar')->whereDate('tanggal', $date)->sum('jumlah') ?? 0;
            }
        }

        return response()->json([
            'labels' => $labels,
            'masuk'  => $dataMasuk,
            'keluar' => $dataKeluar
        ]);
    }
}