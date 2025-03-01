<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageToPdfController extends Controller
{
     public function convert(Request $request)
        {
            // Validasi input file
            $request->validate([
                'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            ]);
    
            // Ambil file gambar
            $image = $request->file('image');
    
            // Path untuk menyimpan file sementara
            $imagePath = $image->getPathname();
            $outputPdf = public_path('converted.pdf');
    
            try {
                // Buat instance Imagick
                $imagick = new \Imagick();
                $imagick->readImage($imagePath);
    
                // Konversi gambar ke PDF
                $imagick->setImageFormat('pdf');
                $imagick->writeImage($outputPdf);
    
                // Hapus instance Imagick
                $imagick->clear();
                $imagick->destroy();
    
                return response()->download($outputPdf)->deleteFileAfterSend(true);
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Error converting image: ' . $e->getMessage()]);
            }
        }
           
         public function convertToWebp(Request $request)
    {
        // Validasi input file
        $request->validate([
            'image' => 'required|image|mimes:png|max:2048', // Hanya menerima file PNG
        ]);
    
        // Ambil file gambar
        $image = $request->file('image');
    
        // Path untuk menyimpan file sementara
        $imagePath = $image->getPathname();
        $outputWebp = public_path('converted.webp');
    
        try {
            // Buat instance Imagick
            $imagick = new \Imagick();
            $imagick->readImage($imagePath);
    
            // Konversi gambar ke WebP
            $imagick->setImageFormat('webp');
            $imagick->writeImage($outputWebp);
    
            // Hapus instance Imagick
            $imagick->clear();
            $imagick->destroy();
    
            return response()->download($outputWebp)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error converting image: ' . $e->getMessage()]);
        }
    }
    
    public function convertPngToJpg(Request $request)
{
    // Validasi input file
    $request->validate([
        'image' => 'required|image|mimes:png|max:2048',
    ]);

    // Ambil file gambar
    $image = $request->file('image');

    // Path untuk menyimpan file sementara
    $imagePath = $image->getPathname();
    $outputJpg = public_path('converted.jpg');

    try {
        // Buat instance Imagick
        $imagick = new \Imagick();

        // Baca gambar PNG
        $imagick->readImage($imagePath);

        // Set format gambar menjadi JPG
        $imagick->setImageFormat('jpg');

        // Simpan gambar sebagai JPG
        $imagick->writeImage($outputJpg);

        // Hapus instance Imagick
        $imagick->clear();
        $imagick->destroy();

        // Kembalikan hasil konversi
        return response()->download($outputJpg)->deleteFileAfterSend(true);
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Error converting PNG to JPG: ' . $e->getMessage()]);
    }
}

public function convertJpgToPng(Request $request)
{
    // Validasi input file
    $request->validate([
        'image' => 'required|image|mimes:jpeg,jpg|max:2048',
    ]);

    // Ambil file gambar
    $image = $request->file('image');

    // Path untuk menyimpan file sementara
    $imagePath = $image->getPathname();
    $outputPng = public_path('converted.png');

    try {
        // Buat instance Imagick
        $imagick = new \Imagick();

        // Baca gambar JPG
        $imagick->readImage($imagePath);

        // Set format gambar menjadi PNG
        $imagick->setImageFormat('png');

        // Simpan gambar sebagai PNG
        $imagick->writeImage($outputPng);

        // Hapus instance Imagick
        $imagick->clear();
        $imagick->destroy();

        // Kembalikan hasil konversi
        return response()->download($outputPng)->deleteFileAfterSend(true);
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Error converting JPG to PNG: ' . $e->getMessage()]);
    }
}
}
