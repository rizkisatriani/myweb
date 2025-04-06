<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KeuanganController extends Controller
{
    /**
     * Menampilkan semua data keuangan
     */
    public function index(Request $request){
        $userId = auth()->id(); // Ambil ID user yang sedang login ===> next 
        $query = Keuangan::where('user_id', $userId); // Hanya data milik user login 
        if ($request->has('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        } 
        if ($request->has('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        } 
        if ($request->has('tanggal_awal') && $request->has('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        } 
    
        return response()->json($query->orderBy('tanggal', 'desc')->orderBy('id', 'desc')->paginate(10));
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
            'user_id' => auth()->id(),
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

    public function getSummary(Request $request)
{
    $query = Keuangan::query();

    // Filter berdasarkan bulan dan tahun
    if ($request->filled('bulan') && $request->filled('tahun')) {
        $query->whereMonth('tanggal', $request->bulan)
              ->whereYear('tanggal', $request->tahun);
    }

    // Filter berdasarkan rentang tanggal
    if ($request->filled('tanggal_awal')) {
        $query->whereDate('tanggal', '>=', $request->tanggal_awal);
    }
    if ($request->filled('tanggal_akhir')) {
        $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
    }

    // Filter berdasarkan user yang login
    $query->where('user_id', auth()->id());

    // Hitung total masuk, keluar, dan saldo terakhir
    $totalMasuk = $query->sum('masuk');
    $totalKeluar = $query->sum('keluar');
    $saldoAkhir = $totalMasuk-$totalKeluar;

    return response()->json([
        'total_masuk' => $totalMasuk,
        'total_keluar' => $totalKeluar,
        'saldo_akhir' => $saldoAkhir
    ]);
}
public function getSaldoAkhirPerBulan()
{
    $userId=auth()->id();
    $tahunIni = Carbon::now()->year;

    // Ambil saldo_akhir terakhir per bulan berdasarkan user_id
    $dataSaldoAkhir = Keuangan::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('MAX(tanggal) as tanggal_terakhir')
        )
        ->whereYear('tanggal', $tahunIni)
        ->where('user_id', $userId)
        ->groupBy(DB::raw('MONTH(tanggal)'))
        ->get();

    // Ambil saldo_akhir berdasarkan tanggal terakhir yang ditemukan per bulan
    $saldoAkhirPerBulan = [];
    foreach ($dataSaldoAkhir as $data) {
        $saldoAkhir = Keuangan::where('user_id', $userId)
            ->whereDate('tanggal', $data->tanggal_terakhir)
            ->orderBy('tanggal', 'desc')
            ->value('saldo_akhir');

        $saldoAkhirPerBulan[$data->bulan] = $saldoAkhir ?? 0;
    }

    // Pastikan semua 12 bulan terisi, jika tidak ada set default 0
    $result = [];
    for ($i = 1; $i <= 12; $i++) {
        array_push($result, $saldoAkhirPerBulan[$i] ?? 0);
    }

    return response()->json($result);
}
}
