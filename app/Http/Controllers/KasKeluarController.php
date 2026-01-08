<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasKeluarController extends Controller
{
    /**
     * Tampilkan halaman kas keluar
     */
    public function index()
    {
        $data = DB::table('kas_keluar')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('kas_keluar.index', compact('data'));
    }

    /**
     * Simpan data kas keluar
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'    => 'required|date',
            'jumlah'     => 'required|numeric|min:1',
            'tujuan'     => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        DB::table('kas_keluar')->insert([
            'tanggal'    => $request->tanggal,
            'jumlah'     => $request->jumlah,
            'tujuan'     => $request->tujuan,
            'keterangan' => $request->keterangan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Data kas keluar berhasil ditambahkan');
    }

    /**
     * Update data kas keluar
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal'    => 'required|date',
            'jumlah'     => 'required|numeric|min:1',
            'tujuan'     => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        DB::table('kas_keluar')
            ->where('id', $id)
            ->update([
                'tanggal'    => $request->tanggal,
                'jumlah'     => $request->jumlah,
                'tujuan'     => $request->tujuan,
                'keterangan' => $request->keterangan,
                'updated_at' => now(),
            ]);

        return redirect()->back()
            ->with('success', 'Data kas keluar berhasil diperbarui');
    }

    /**
     * Hapus data kas keluar
     */
    public function destroy($id)
    {
        DB::table('kas_keluar')
            ->where('id', $id)
            ->delete();

        return redirect()->back()
            ->with('success', 'Data kas keluar berhasil dihapus');
    }
}
