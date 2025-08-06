<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageEnhanceController extends Controller
{
  public function index()
    {
        return view('enhance');
    }

    public function enhance(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // Maks 5MB
        ]);

        $inputFile = $request->file('image');
        $inputPath = storage_path('app/input.jpg');
        $outputPath = storage_path('app/output.jpg');

        // Simpan file ke storage sementara
        $inputFile->move(storage_path('app'), 'input.jpg');

        // Jalankan waifu2x-converter-cpp
        $cmd = "waifu2x-converter-cpp -i {$inputPath} -o {$outputPath} --scale-ratio 2 --noise-level 3 --mode noise-scale --model-dir /var/www/imgEnhance/waifu2x-converter-cpp/models_rgb";
        exec($cmd, $output, $exitCode);

        if (!file_exists($outputPath) || $exitCode !== 0) {
            return back()->withErrors(['Gagal memproses gambar.']);
        }

        // Simpan hasil ke direktori public agar bisa ditampilkan
        $finalName = 'enhanced_' . time() . '.jpg';
        $publicPath = public_path('images/' . $finalName);

        File::ensureDirectoryExists(public_path('images'));
        File::copy($outputPath, $publicPath);

        return view('enhance', [
            'imagePath' => asset('images/' . $finalName)
        ]);
    }
}
