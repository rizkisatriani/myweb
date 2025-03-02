<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageToPdfController; 
use App\Http\Controllers\DocConvertController; 
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/generate-sitemap', function () {
    // Ambil semua route yang ada di aplikasi
    $routes = Route::getRoutes();

    // Buat objek sitemap
    $sitemap = Sitemap::create();

    // Iterasi setiap route dan tambahkan ke sitemap
    foreach ($routes as $route) {
        // Pastikan hanya URL yang diakses melalui GET yang dimasukkan ke sitemap
        if ($route->methods[0] === 'GET') {
            // Ambil URL dari route
            $url = url($route->uri);

            // Tambahkan URL ke sitemap
            $sitemap->add(Url::create($url));
        }
    }

    // Simpan sitemap ke file
    $sitemap->writeToFile(public_path('sitemap.xml'));

    return response()->download(public_path('sitemap.xml'));
});
Route::get('/', function () {
    return view('welcome', [
        'breadCrumb' => 'Toolsborg Tools Online Center',
        'title' => 'Toolsborg Tools Online Center',
        'subtitle' => 'Manage your image files better and save on storage space by converting PNG files to JPG. Use our free PNG to JPG converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
        'actionUrl' => 'convert-png-to-jpg',
    ]);
});

Route::get('/convert-jpg-to-pdf', function () {
    return view('convertjpgtopdf', [
            'breadCrumb' => 'JPG to PDF Tool',
            'title' => 'Convert JPG to PDF for free',
            'subtitle' => 'Manage your image files better and save on storage space by converting JPG files to PDF. Use our free JPG to PDF converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
            'actionUrl' => 'convert-jpg-to-pdf',
        ]);
});

Route::get('/convert-png-to-pdf', function () {
    return view('convertjpgtopdf', [
            'breadCrumb' => 'PNG to PDF Tool',
            'title' => 'Convert PNG to PDF for free',
            'subtitle' => 'Manage your image files better and save on storage space by converting PNG files to PDF. Use our free PNG to PDF converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
            'actionUrl' => 'convert-jpg-to-pdf',
        ]);
});


Route::get('/convert-png-to-jpg', function () {
    return view('convertjpgtopdf', [
            'breadCrumb' => 'PNG to JPG Tool',
            'title' => 'Convert PNG to JPG for free',
            'subtitle' => 'Manage your image files better and save on storage space by converting PNG files to JPG. Use our free PNG to JPG converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
            'actionUrl' => 'convert-png-to-jpg',
        ]);
});


Route::get('/convert-jpg-to-png', function () {
    return view('convertjpgtopdf', [
            'breadCrumb' => 'JPG to PNG Tool',
            'title' => 'Convert JPG to PNG for free',
            'subtitle' => 'Manage your image files better and save on storage space by converting JPG files to PNG. Use our free JPG to PNG converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
            'actionUrl' => 'convert-jpg-to-png',
        ]);
});

Route::get('/convert-png-to-webp', function () {
    return view('convertjpgtopdf', [
            'breadCrumb' => 'PNG to WEBP Tool',
            'title' => 'Convert PNG to WEBP for free',
            'subtitle' => 'Manage your image files better and save on storage space by converting PNG files to WEBP. Use our free PNG to WEBP converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
            'actionUrl' => 'convert-png-to-webp',
        ]);
});

Route::get('/convert-word-to-pdf', function () {
    return view('convertdoc', [
            'breadCrumb' => 'WORD to PDF Tool',
            'title' => 'Convert WORD to PDF for free',
            'subtitle' => 'Manage your image files better and save on storage space by converting WORD files to PDF. Use our free WORD to PDF converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
            'actionUrl' => 'convert-word-to-pdf',
        ]);
});
Route::get('/convert-ppt-to-pdf', function () {
    return view('convertdoc', [
            'breadCrumb' => 'PPT/PPTX to PDF Tool',
            'title' => 'Convert PPT/PPTX to PDF for free',
            'subtitle' => 'Manage your image files better and save on storage space by converting PPT/PPTX files to PPT/PPTX. Use our free WORD to PDF converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
            'actionUrl' => 'convert-ppt-to-pdf',
        ]);
});
Route::post('convert-jpg-to-pdf', [ImageToPdfController::class, 'convert']);
Route::post('convert-png-to-webp', [ImageToPdfController::class, 'convertToWebp']);
Route::post('convert-png-to-jpg', [ImageToPdfController::class, 'convertPngToJpg']);
Route::post('convert-jpg-to-png', [ImageToPdfController::class, 'convertJpgToPng']);
Route::post('/convert-word-to-pdf', [DocConvertController::class, 'convertWordToPdf']);
Route::post('/convert-ppt-to-pdf', [DocConvertController::class, 'convertPptToPdf']);
Route::get('/speed-test-internet', function () {
    return view('speedtest', [
        'breadCrumb' => 'Test Speed Internet',
        'title' => 'Test Speed Internet for free',
        'subtitle' => 'Manage your image files better and save on storage space by converting PPT/PPTX files to PPT/PPTX. Use our free WORD to PDF converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
        'actionUrl' => 'convert-ppt-to-pdf',
    ]);
});
Route::get('/dummy-data', function () {
    $filename = 'dummy-file.txt';

    return Response::stream(function () {
        $chunkSize = 1024 * 1024; // 1 MB per chunk
        $totalSize = 1 * $chunkSize; // 10 MB total data
        $data = base64_encode(str_repeat('A', $chunkSize)); // Base64-encoded string of 'A' characters

        for ($i = 0; $i < $totalSize / $chunkSize; $i++) {
            echo $data; // Output the encoded string
            flush(); // Ensure the chunk is sent immediately
            usleep(500000); // Slow down the output by adding a 0.5 second delay
        }
    }, 200, [
        'Content-Type' => 'text/plain',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ]);
});

Route::post('/dummy-data', function () {
    return response()->json(['status' => 'ok']);
});