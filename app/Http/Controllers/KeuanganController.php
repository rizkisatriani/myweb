<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use Illuminate\Support\Facades\Storage;

class KeuanganController extends Controller
{
    /**
     * Menampilkan semua data keuangan
     */
    public function index(Request $request){
        // $userId = auth()->id(); // Ambil ID user yang sedang login ===> next 
        // $query = Keuangan::where('user_id', $userId); // Hanya data milik user login
        $query = Keuangan::query();

        // Filter berdasarkan bulan (opsional)
        if ($request->has('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
    
        // Filter berdasarkan tahun (opsional)
        if ($request->has('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }
    
        // Filter berdasarkan rentang tanggal
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }
    
        // Urutkan berdasarkan tanggal terbaru
        $keuangan = $query->orderBy('tanggal', 'desc')->get();
    
        return response()->json($keuangan);
    }

    /**
     * Menyimpan data keuangan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'masuk' => 'nullable|numeric|min:0',
            'keluar' => 'nullable|numeric|min:0',
            'tanggal' => 'required|date',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti_keuangan', 'public');
        }

        // Ambil saldo terakhir
        $saldoTerakhir = Keuangan::latest()->value('saldo_akhir') ?? 0;

        // Hitung saldo baru
        $saldoBaru = $saldoTerakhir + ($request->masuk ?? 0) - ($request->keluar ?? 0);

        $keuangan = Keuangan::create([
            'deskripsi' => $request->deskripsi,
            'masuk' => $request->masuk ?? 0,
            'keluar' => $request->keluar ?? 0,
            'saldo_akhir' => $saldoBaru,
            'tanggal' => $request->tanggal,
            'bukti' => $buktiPath,
        ]);

        return response()->json($keuangan, 201);
    }

    /**
     * Menampilkan detail keuangan berdasarkan ID
     */
    public function show($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        return response()->json($keuangan);
    }

    /**
     * Memperbarui data keuangan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'sometimes|string',
            'masuk' => 'nullable|numeric|min:0',
            'keluar' => 'nullable|numeric|min:0',
            'tanggal' => 'sometimes|date',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $keuangan = Keuangan::findOrFail($id);

        // Jika bukti diupdate, hapus yang lama
        if ($request->hasFile('bukti')) {
            if ($keuangan->bukti) {
                Storage::disk('public')->delete($keuangan->bukti);
            }
            $keuangan->bukti = $request->file('bukti')->store('bukti_keuangan', 'public');
        }

        // Update field lainnya
        $keuangan->update($request->except(['bukti']));

        // Update saldo_akhir untuk semua data berikutnya
        $this->updateSaldoAfter($keuangan->id);

        return response()->json($keuangan);
    }

    /**
     * Menghapus data keuangan
     */
    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);

        if ($keuangan->bukti) {
            Storage::disk('public')->delete($keuangan->bukti);
        }

        $keuangan->delete();

        // Update saldo_akhir setelah penghapusan
        $this->updateSaldoAfter($id);

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    /**
     * Mengupdate saldo_akhir untuk semua data setelah perubahan
     */
    private function updateSaldoAfter($startId)
    {
        $keuanganList = Keuangan::where('id', '>=', $startId)->orderBy('id')->get();
        $saldo = Keuangan::where('id', '<', $startId)->orderBy('id', 'desc')->value('saldo_akhir') ?? 0;

        foreach ($keuanganList as $keuangan) {
            $saldo = $saldo + $keuangan->masuk - $keuangan->keluar;
            $keuangan->update(['saldo_akhir' => $saldo]);
        }
    }
}
