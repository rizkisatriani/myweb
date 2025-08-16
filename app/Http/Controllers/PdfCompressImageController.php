<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\PdfToImage\Pdf;
use FPDF;

class PdfCompressImageController extends Controller
{
    public function form()
    {
        return view('compres_form_upload', [
            'breadCrumb' => 'Merge PDF',
            'title' => 'Merge PDF',
            'subtitle' => 'Combine multiple PDF files into a single document quickly and easily 🚀',
        ]);
    }
    public function upload(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimetypes:application/pdf|max:51200',
        ], [
            'pdf.required'  => 'Pilih file PDF.',
            'pdf.mimetypes' => 'File harus PDF.',
            'pdf.max'       => 'Maksimal ukuran file 50MB.',
        ]);

        $file   = $request->file('pdf');
        $bucket = (string) Str::uuid();

        // Simpan: storage/app/public/tmp/{bucket}/original.pdf
        $relDir  = "tmp/{$bucket}";
        $relPath = "{$relDir}/original.pdf";
        Storage::disk('public')->putFileAs($relDir, $file, 'original.pdf');

        // Nama asli untuk ditampilkan di halaman edit
        $name = $file->getClientOriginalName();

        // >>> PREVIEW LINK di sini <<<
        // Perlu: php artisan storage:link  (dan APP_URL diset)
        $previewUrl = Storage::disk('public')->url($relPath);
        // Jika mau pakai helper asset():
        // $previewUrl = asset('storage/'.$relPath);

        // Kalau request-nya AJAX / expecting JSON → balas JSON (enak untuk UI dinamis)
        if ($request->wantsJson()) {
            return response()->json([
                'ok'          => true,
                'bucket'      => $bucket,
                'name'        => $name,
                'preview_url' => $previewUrl,                                       // <—
                'edit_url'    => route('pdf.compress.edit', compact('bucket', 'name')),
            ]);
        } 
        // Kalau non-AJAX → redirect ke halaman edit
        // (tetap kirim preview_url via flash/session jika mau dipakai di view)
          return view('compres_form', [
            'bucket' => $bucket, 'name' => $name,
            'previewUrl' => $previewUrl,
            'title' => 'Merge PDF',
            'subtitle' => 'Combine multiple PDF files into a single document quickly and easily 🚀',
        ]);
        return view('pdf_compress.edit', compact('previewUrl', 'name','bucket'));
        // return redirect()
        //     ->route('pdf.compress.edit', ['bucket' => $bucket, 'name' => $name])
        //     ->with('preview_url', $previewUrl);                                    // <—
    }
    public function edit(Request $request, string $bucket)
    {
        $relPath = "tmp/{$bucket}/original.pdf";
        if (!Storage::disk('public')->exists($relPath)) {
            return redirect()->route('pdf.compress.form')->withErrors('File tidak ditemukan atau sudah kedaluwarsa.');
        }

        $previewUrl = Storage::disk('public')->url($relPath);
        $name = $request->query('name') ?: basename($relPath);

        return view('pdf_compress.edit', compact('previewUrl', 'name'));
    }
    public function index()
    {
        $imagickLoaded = extension_loaded('imagick');
        return view('compres_form', [
            'breadCrumb' => 'Merge PDF',
            'title' => 'Merge PDF',
            'subtitle' => 'Combine multiple PDF files into a single document quickly and easily 🚀',
            'imagickLoaded' => $imagickLoaded,
        ]);
    }

    public function compress(Request $request)
    {
        $request->validate([
            'pdf'     => 'required|file|mimetypes:application/pdf',
            'quality' => 'nullable|integer|min:10|max:100', // JPEG quality
            'dpi'     => 'nullable|integer|min:72|max:300', // render DPI
        ]);

        // Wajib: Imagick aktif (spatie/pdf-to-image pakai Imagick + Ghostscript di sistem)
        if (!extension_loaded('imagick')) {
            return back()->withErrors('Ekstensi Imagick belum aktif. Aktifkan Imagick (beserta ImageMagick + Ghostscript) di server.');
        }

        $file     = $request->file('pdf');
        $quality  = (int)($request->input('quality', 60)); // default 60
        $dpi      = (int)($request->input('dpi', 144));    // default 144
        $tmpId    = Str::uuid()->toString();
        $tmpDir   = storage_path("app/tmp/$tmpId");
        $outName  = 'compressed-' . Str::random(6) . '.pdf';
        $outPath  = storage_path("app/public/$outName");

        if (!is_dir($tmpDir)) {
            mkdir($tmpDir, 0775, true);
        }

        $originalBytes = @filesize($file->getRealPath()) ?: 0;

        try {
            // v3 API: quality(), resolution(), pageCount(), selectPage(), save()
            $renderer = (new Pdf($file->getRealPath()))
                ->quality($quality)
                ->resolution($dpi);

            $pageCount = $renderer->pageCount();

            // Bangun ulang PDF dari gambar
            $fpdf = new \FPDF();

            for ($page = 1; $page <= $pageCount; $page++) {
                $jpgPath = "$tmpDir/page-$page.jpg";

                // Simpan halaman ke JPG (format diambil dari ekstensi .jpg)
                $renderer->selectPage($page)->save($jpgPath);

                // Hitung ukuran halaman mm dari pixel & DPI
                [$pxW, $pxH] = getimagesize($jpgPath);
                if (!$pxW || !$pxH) {
                    throw new \RuntimeException("Gagal membaca ukuran gambar untuk halaman $page.");
                }

                $mmW = $pxW * 25.4 / $dpi; // mm = px * 25.4 / dpi
                $mmH = $pxH * 25.4 / $dpi;

                $orientation = $mmW >= $mmH ? 'L' : 'P';
                $fpdf->AddPage($orientation, [$mmW, $mmH]);
                $fpdf->Image($jpgPath, 0, 0, $mmW, $mmH);
            }

            // Simpan PDF hasil
            $fpdf->Output('F', $outPath);
        } catch (\Throwable $e) {
            // Cleanup bila error
            foreach (glob("$tmpDir/*") ?: [] as $p) @unlink($p);
            @rmdir($tmpDir);
            dd('Gagal memproses PDF: ' . $e);
            return back()->withErrors('Gagal memproses PDF: ' . $e->getMessage());
        }

        // Cleanup file sementara
        foreach (glob("$tmpDir/*") ?: [] as $p) @unlink($p);
        @rmdir($tmpDir);

        // (Opsional) simpan ke disk 'public' untuk bisa diakses via URL /storage/...
        // Di sini sudah tersimpan ke $outPath (storage/app/public/...), jadi baris di bawah tidak wajib:
        // Storage::disk('public')->put($outName, file_get_contents($outPath));

        // Jika butuh info penghematan ukuran, bisa dihitung di sini:
        // $compressedBytes = @filesize($outPath) ?: 0;
        // $savedPct = $originalBytes > 0 ? round(($originalBytes - $compressedBytes) / $originalBytes * 100, 1) : 0;

        // Kembalikan file ke user
        return response()->download($outPath)->deleteFileAfterSend(true);
    }
}
