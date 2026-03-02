<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasMasukController extends Controller
{
    /**
     * Tampilkan halaman kas masuk
     */
    public function index()
    {
        $data = DB::table('kas_masuk')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('kas_masuk.index', compact('data'));
    }

    /**
     * Simpan data kas masuk
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'  => 'required|date',
            'jumlah'   => 'required|numeric|min:1',
            'sumber'   => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::table('kas_masuk')->insert([
            'tanggal'    => $request->tanggal,
            'jumlah'     => $request->jumlah,
            'sumber'     => $request->sumber,
            'quantity'   => $request->quantity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Data kas masuk berhasil ditambahkan');
    }

    /**
     * Update data kas masuk
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal'  => 'required|date',
            'jumlah'   => 'required|numeric|min:1',
            'sumber'   => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::table('kas_masuk')
            ->where('id', $id)
            ->update([
                'tanggal'    => $request->tanggal,
                'jumlah'     => $request->jumlah,
                'sumber'     => $request->sumber,
                'quantity'   => $request->quantity,
                'updated_at' => now(),
            ]);

        return redirect()->back()
            ->with('success', 'Data kas masuk berhasil diperbarui');
    }

    /**
     * Hapus data kas masuk
     */
    public function destroy($id)
    {
        DB::table('kas_masuk')
            ->where('id', $id)
            ->delete();

        return redirect()->back()
            ->with('success', 'Data kas masuk berhasil dihapus');
    }
}
