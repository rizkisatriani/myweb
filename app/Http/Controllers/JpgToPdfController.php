<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;

class JpgToPdfController extends Controller
{
    public function showUploadForm()
    {
        return view('uploadJpg', [
            'breadCrumb' => 'JPG to PDF',
            'title' => 'JPG to PDF',
            'subtitle' => 'Convert your JPG images into PDF files quickly and easily 🚀',
            'actionUrl' => null,
        ]);
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $paths = [];
        foreach ($request->file('images') as $image) {
            // Simpan ke storage/app/public/temp_images
            $paths[] = $image->store('temp_images', 'public');
        }

        session(['uploaded_images' => $paths]);

        return redirect()->route('edit.page');
    }

    public function showEditPage()
    {
        $images = session('uploaded_images', []);
        return view('editJpgToPdf',  [
            'breadCrumb' => 'Blog',
            'title' => 'Blog Artikel',
            'subtitle' => 'Kumpulan artikel bermanfaat tentang teknologi, alat online, dan solusi digital 🚀',
            'actionUrl' => null,
            'images' => $images
        ]);
    }

    public function convertToPdf(Request $request)
    {
        $images = $request->input('images', []);
        $orientation = $request->input('orientation', 'portrait');
        $paper = $request->input('paper', 'a4');
        $margin = $request->input('margin', 'none');
        $manager = new ImageManager(new ImagickDriver());

        // Tangani gambar base64 baru (dari preview)
        if ($request->has('new_images_base64')) {
            foreach ($request->input('new_images_base64') as $base64) {
                // Hapus prefix data:image/jpeg;base64,...
                $base64Clean = preg_replace('/^data:image\/\w+;base64,/', '', $base64);
                $binaryData = base64_decode($base64Clean);

                // Baca dan manipulasi gambar
                $image = $manager->read($binaryData);
                $image = $image->scale(width: 1000); // Contoh resize jika perlu

                // Simpan ke storage
                $filename = 'temp_images/' . uniqid() . '.jpg';
                Storage::disk('public')->put($filename, (string) $image->toJpeg(90));

                $images[] = $filename;
            }
        }
        $imagePaths = collect($images)->map(fn($path) => Storage::disk('public')->path($path));

        $pdf = PDF::loadView('pdf_template', [
            'images' => $imagePaths,
            'margin' => $margin,
        ])->setPaper($paper, $orientation);

        return $pdf->download('converted.pdf');
    }
}
