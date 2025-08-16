<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class PdfMergeController extends Controller
{
    public function formUpload()
    {
        return view('merge-upload', [
            'breadCrumb' => 'Merge PDF',
            'title' => 'Merge PDF',
            'subtitle' => 'Combine multiple PDF files into a single document quickly and easily 🚀',
            'actionUrl' => null,
        ]);
    }
    public function handleUpload(Request $request)
    {
        $request->validate([
            'files'   => ['required', 'array', 'min:1'],
            'files.*' => ['file', 'mimetypes:application/pdf', 'max:20480'], // 20MB per file
        ], [
            'files.required' => 'Pilih minimal satu file PDF.',
            'files.*.mimetypes' => 'File harus berformat PDF.',
        ]);

        // bucket unik per sesi
        $bucket = Str::uuid()->toString();
        $basePath = "tmp/pdf-merge/{$bucket}";
        Storage::makeDirectory($basePath);

        foreach ($request->file('files', []) as $idx => $pdf) {
            // Simpan dengan prefix index agar urutan upload jadi urutan awal
            $safe = str_pad((string)$idx, 4, '0', STR_PAD_LEFT) . '_' . Str::uuid() . '.pdf';
            $pdf->storeAs($basePath, $safe);
        }

        return redirect()->route('pdf.merge.edit', ['bucket' => $bucket]);
    }
    public function showEdit(string $bucket)
    {
        $basePath = "tmp/pdf-merge/{$bucket}";
        abort_unless(Storage::exists($basePath), 404);

        $files = collect(Storage::files($basePath))
            ->filter(fn($p) => str_ends_with(strtolower($p), '.pdf'))
            ->values()
            ->map(function ($path) use ($bucket) {
                $name = basename($path);

                // URL bertanda tangan untuk diakses PDF.js (expired default 60 menit — bisa diubah)
                $signed = URL::temporarySignedRoute(
                    'pdf.merge.file',
                    now()->addMinutes(60),
                    ['bucket' => $bucket, 'file' => $name]
                );

                return [
                    'path'       => $path,   // path relative Storage
                    'name'       => $name,
                    'previewUrl' => $signed, // dipakai PDF.js
                ];
            })
            ->all();

        return view('merge-edit', [
            'bucket' => $bucket,
            'files'  => $files,
            'breadCrumb' => 'Merge PDF',
            'title' => 'Merge PDF',
            'subtitle' => 'Combine multiple PDF files into a single document quickly and easily 🚀',
        ]);
    }

    // Hapus file dari bucket (dipanggil via fetch AJAX) 
    public function handleRemove(Request $request)
    {
        $request->validate([
            'bucket' => ['required', 'string'],
            'path'   => ['required', 'string'],
        ]);

        $basePath = "tmp/pdf-merge/{$request->bucket}";
        abort_unless(Storage::exists($basePath), 404);

        $path = ltrim($request->path, '/');
        if (!str_starts_with($path, $basePath)) {
            return response()->json(['ok' => false, 'message' => 'Path tidak valid.'], 422);
        }

        if (Storage::exists($path)) Storage::delete($path);

        return response()->json(['ok' => true]);
    }

    public function merge(Request $request)
    {
        $validated = $request->validate([
            'bucket'      => ['required', 'string'],
            'file_order'  => ['required', 'array', 'min:1'],
            'file_order.*' => ['string'],
        ]);

        $basePath = "tmp/pdf-merge/{$validated['bucket']}";
        abort_unless(Storage::exists($basePath), 404);

        // Normalisasi & validasi semua path ada di bucket
        $paths = array_map(function ($p) use ($basePath) {
            $p = ltrim($p, '/');
            abort_unless(str_starts_with($p, $basePath), 422, 'Path tidak valid.');
            abort_unless(Storage::exists($p), 422, 'File hilang.');
            return Storage::path($p); // absolute path untuk FPDI
        }, $validated['file_order']);

        $pdf = new Fpdi();               // orientasi/size akan mengikuti tiap halaman sumber
        $pdf->SetAutoPageBreak(false);

        foreach ($paths as $abs) {
            $pageCount = $pdf->setSourceFile($abs);
            for ($page = 1; $page <= $pageCount; $page++) {
                $tplId = $pdf->importPage($page);
                $size  = $pdf->getTemplateSize($tplId);

                $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
                $pdf->AddPage($orientation, [$size['width'], $size['height']]);
                $pdf->useTemplate($tplId, 0, 0, $size['width'], $size['height']);
            }
        }

        $binary = $pdf->Output('S');
        $filename = 'merged-' . now()->format('Ymd-His') . '.pdf';

        // (opsional) bersihkan bucket setelah merge:
        // Storage::deleteDirectory($basePath);

        return response($binary, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Content-Length'      => strlen($binary),
        ]);
    }
    public function file(Request $request, string $bucket, string $file)
    {
        $basePath = "tmp/pdf-merge/{$bucket}";
        abort_unless(Storage::exists($basePath), 404);

        $full = "{$basePath}/{$file}";
        abort_unless(Storage::exists($full), 404);

        // amankan hanya PDF
        abort_unless(str_ends_with(strtolower($full), '.pdf'), 403);

        $binary = Storage::get($full);
        return response($binary, 200, [
            'Content-Type'  => 'application/pdf',
            'Cache-Control' => 'private, max-age=1800', // 30 menit
        ]);
    }
    public function uploadMore(Request $request)
    {
        try {
            $validated = $request->validate([
                'bucket'  => ['required', 'string'],
                'files'   => ['required', 'array', 'min:1'],
                'files.*' => ['file', 'mimetypes:application/pdf', 'max:50480'], // 50,480 KB ≈ 49.3 MB
            ]);

            // ... proses upload

            return response()->json(['ok' => true]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $bucket   = $request->input('bucket');
        $basePath = "tmp/pdf-merge/{$bucket}";
        abort_unless(Storage::exists($basePath), 404);

        $added = [];
        foreach ($request->file('files', []) as $pdf) {
            // keep a sortable-friendly prefix to preserve order of this batch
            $name = now()->format('His') . '_' . Str::uuid() . '.pdf';
            $rel  = $pdf->storeAs($basePath, $name);

            $signed = URL::temporarySignedRoute(
                'pdf.merge.file',
                now()->addMinutes(60),
                ['bucket' => $bucket, 'file' => basename($rel)]
            );

            $added[] = [
                'path'       => $rel,
                'name'       => basename($rel),
                'previewUrl' => $signed,
            ];
        }

        return response()->json(['ok' => true, 'items' => $added]);
    }
}
