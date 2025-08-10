<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageToPdfController; 
use App\Http\Controllers\DocConvertController;
use App\Http\Controllers\ImageEnhanceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JpgToPdfController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\SitemapController;
use App\Models\Blog;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
Route::get('/', function () {
    $blogs = Blog::orderBy('published_at', 'desc')->limit(3)->get();
    return view('welcome', [
        'breadCrumb' => 'Toolsborg Tools Online Center',
        'title' => 'Toolsborg Tools Online Center',
        'subtitle' => 'Manage your image files better and save on storage space by converting PNG files to JPG. Use our free PNG to JPG converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
        'actionUrl' => 'en/convert-png-to-jpg',
        'blogs' => $blogs, 
    ]);
});

Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'en|id']], function () {
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

    // return response()->download(public_path('sitemap.xml'));
});
Route::get('/', function () {
    return view('welcome', [
        'breadCrumb' => 'Toolsborg Tools Online Center',
        'title' => 'Toolsborg Tools Online Center',
        'subtitle' => 'Manage your image files better and save on storage space by converting PNG files to JPG. Use our free PNG to JPG converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
        'actionUrl' => 'en/convert-png-to-jpg',
    ]);
})->name('home');

Route::get('/convert-jpg-to-pdf',  [JpgToPdfController::class, 'showUploadForm']);
// , function () {
//     return view('convertjpgtopdf', [
//             'breadCrumb' => 'JPG to PDF Tool',
//             'title' =>   __('convertjpgtopdf.title', [
//                 'from' => 'JPG', 
//                 'to' => 'PDF',  
//             ]),
//             'subtitle' =>   __('convertjpgtopdf.subtitle', [
//                 'from' => 'JPG', 
//                 'to' => 'PDF',  
//                 'from_to' => 'JPG to PDF'
//             ]),
//             'actionUrl' => 'en/convert-jpg-to-pdf',
//         ]);
// });

Route::get('/convert-png-to-pdf',  [JpgToPdfController::class, 'showUploadForm']);
// , function () {
//     return view('convertjpgtopdf', [
//             'breadCrumb' => 'PNG to PDF Tool',
//             'title' => 'Convert PNG to PDF for free',
//             'subtitle' => 'Manage your image files better and save on storage space by converting PNG files to PDF. Use our free PNG to PDF converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
//             'actionUrl' => 'en/convert-jpg-to-pdf',
//         ]);
// });


Route::get('/convert-png-to-jpg', function () {
    return view('convertjpgtopdf', [
            'breadCrumb' => 'PNG to JPG Tool',
            'title' => 'Convert PNG to JPG for free',
            'subtitle' => 'Manage your image files better and save on storage space by converting PNG files to JPG. Use our free PNG to JPG converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
            'actionUrl' => 'en/convert-png-to-jpg',
        ]);
});


Route::get('/convert-jpg-to-png', function () {
    return view('convertjpgtopdf', [
            'breadCrumb' => 'JPG to PNG Tool',
            'title' => 'Convert JPG to PNG for free',
            'subtitle' => 'Manage your image files better and save on storage space by converting JPG files to PNG. Use our free JPG to PNG converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
            'actionUrl' => 'en/convert-jpg-to-png',
        ]);
});

Route::get('/convert-png-to-webp', function () {
    return view('convertjpgtopdf', [
            'breadCrumb' => 'PNG to WEBP Tool',
            'title' => 'Convert PNG to WEBP for free',
            'subtitle' => 'Manage your image files better and save on storage space by converting PNG files to WEBP. Use our free PNG to WEBP converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
            'actionUrl' => 'en/convert-png-to-webp',
        ]);
});

Route::get('/convert-word-to-pdf', function () {
    return view('convertdoc', [
            'breadCrumb' => 'WORD to PDF Tool',
            'title' => 'Convert WORD to PDF for free',
            'subtitle' => 'Manage your image files better and save on storage space by converting WORD files to PDF. Use our free WORD to PDF converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
            'actionUrl' => 'en/convert-word-to-pdf',
        ]);
});
Route::get('/convert-ppt-to-pdf', function () {
    return view('convertdoc', [
            'breadCrumb' => 'PPT/PPTX to PDF Tool',
            'title' => 'Convert PPT/PPTX to PDF for free',
            'subtitle' =>   __('convertjpgtopdf.subtitle_ppt'),
            'actionUrl' => 'en/convert-ppt-to-pdf',
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

Route::get('/qrcode-generator-free', function () {
    $qrCode = QrCode::size(200)->generate('https://toolsborg.com');
    return view('generateqrcode', [
            'breadCrumb' => 'Free Generator QR Code',
            'title' => 'Free Generator QR Code',
            'subtitle' => 'Free Generator QR Code ',
            'actionUrl' => 'convert-jpg-to-pdf',
            'qrCode' => $qrCode,
            'text' => 'https://toolsborg.com',
            'qrCodeDownloadUrl' =>'/download-qrcode?text='.'https://toolsborg.com',
            'qrCodePrintdUrl' =>'/print-qrcode?text='.'https://toolsborg.com'
        ]);
});


Route::post('/qrcode-generator-free', function (Request $request) {
    $request->validate([
        'text' => 'required|string|max:255',
    ]);

    $qrCode = QrCode::size(200)->generate($request->text);
    // dd($request->frame);
    return view('generateqrcode', [
            'breadCrumb' => 'Generate QrCode Tool',
            'title' => 'Convert JPG to PDF for free',
            'subtitle' => 'Manage your image files better and save on storage space by converting JPG files to PDF. Use our free JPG to PDF converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
            'actionUrl' => 'convert-jpg-to-pdf',
            'qrCode' => $qrCode,
            'frame' => $request->frame,
            'text' => $request->text,
            'qrCodeDownloadUrl' =>'/download-qrcode?text='.$request->text,
            'qrCodePrintdUrl' =>'/print-qrcode?text='.$request->text
        ]);
})->name('qrcode.generate');
Route::get('/download-qrcode', [QRCodeController::class, 'downloadQRCodeUrl']);

Route::get('/print-qrcode', function (Request $request) {
    $qrCode = QrCode::size(300)->generate($request->text); // Change the URL or data

    return view('printqrcode',  [
        'breadCrumb' => 'JPG to PDF Tool',
        'title' => 'Print QR Code',
        'subtitle' => 'Manage your image files better and save on storage space by converting JPG files to PDF. Use our free JPG to PDF converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
        'actionUrl' => 'convert-jpg-to-pdf',
        'qrCode' => $qrCode
    ]);
});


Route::get('/contact-qrcode-generator-free', function () {
    $qrCode = QrCode::size(200)->generate('https://toolsborg.com');
    return view('generateqrcodeforcontact', [
            'breadCrumb' => 'Free Generator QR Code',
            'title' => 'Free Generator QR Code',
            'subtitle' => 'Free Generator QR Code ',
            'actionUrl' => 'convert-jpg-to-pdf',
            'qrCode' => $qrCode,
            'text' => 'https://toolsborg.com',
            'qrCodeDownloadUrl' =>'/download-qrcode?text='.'https://toolsborg.com',
            'qrCodePrintdUrl' =>'/print-qrcode?text='.'https://toolsborg.com'
        ]);
});

Route::post('/contact-qrcode-generator-free', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'address' => 'nullable|string|max:255',
    ]);

    $vCard = "BEGIN:VCARD\nVERSION:3.0\n";
    $vCard .= "N:{$request->name}\n";
    $vCard .= "TEL:{$request->phone}\n";
    $vCard .= "EMAIL:{$request->email}\n";
    if (!empty($request->address)) {
        $vCard .= "ADR:{$request->address}\n";
    }
    $vCard .= "END:VCARD";

    $qrCode = QrCode::size(200)->generate($vCard);

    return view('generateqrcodeforcontact', [
        'breadCrumb' => 'Generate Contact QR Code',
        'title' => 'Generate Contact QR Code for Free',
        'subtitle' => 'Easily create a QR Code containing contact details that can be scanned to save information directly.',
        'actionUrl' => 'qrcode-generator-free',
        'qrCode' => $qrCode,
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
        'address' => $request->address,
        'qrCodeDownloadUrl' => '/download-qrcode?text=' . urlencode($vCard),
        'qrCodePrintdUrl' => '/print-qrcode?text=' . urlencode($vCard)
    ]);
})->name('qrcode.generate_contact');

 
Route::get('/wifi-qrcode-generator-free', function () {
    $qrCode = QrCode::size(200)->generate('https://toolsborg.com');
    return view('generateqrcodeforwifi', [
            'breadCrumb' => 'Free Generator QR Code',
            'title' => 'Free Generator QR Code',
            'subtitle' => 'Free Generator QR Code ',
            'actionUrl' => 'convert-jpg-to-pdf',
            'qrCode' => $qrCode,
            'text' => 'https://toolsborg.com',
            'qrCodeDownloadUrl' =>'/download-qrcode?text='.'https://toolsborg.com',
            'qrCodePrintdUrl' =>'/print-qrcode?text='.'https://toolsborg.com'
        ]);
});

Route::post('/wifi-qrcode-generator-free', function (Request $request) {
    $ssid = $request->input('ssid');
    $encryption = $request->input('encryption', 'WPA'); // Default WPA
    $password = $request->input('password', '');

    // Format WiFi QR Code
    $wifiData = "WIFI:S:{$ssid};T:{$encryption};P:{$password};;";
    
    $qrCode = QrCode::size(300)->generate($wifiData);

    return view('generateqrcodeforwifi', [
        'breadCrumb' => 'Generate Contact QR Code',
        'title' => 'Generate Contact QR Code for Free',
        'subtitle' => 'Easily create a QR Code containing contact details that can be scanned to save information directly.',
        'actionUrl' => 'qrcode-generator-free',
        'ssid'=>$ssid,
        'qrCode' => $qrCode, 
        'qrCodeDownloadUrl' => '/download-qrcode?text=' . urlencode($wifiData),
        'qrCodePrintdUrl' => '/print-qrcode?text=' . urlencode($wifiData)
    ]);
})->name('qrcode.generate_wifi');

Route::get('/cbt', function () {
    return view('cbt', [
        'breadCrumb' => 'Aplikasi Com base Test',
        'title' => 'Aplikasi Com base Test',
        'subtitle' => 'Solusi Ujian Berbasis Komputer yang Efisien, Akurat, dan Mudah Dikelola! 🚀',
        'actionUrl' => 'en/convert-png-to-jpg',
    ]);
});

Route::get('/gheet-pengelola-keuangan', function () {
    return view('gsheet', [
        'breadCrumb' => 'Aplikasi Com base Test',
        'title' => 'Aplikasi Com base Test',
        'subtitle' => 'Solusi Ujian Berbasis Komputer yang Efisien, Akurat, dan Mudah Dikelola! 🚀',
        'actionUrl' => 'en/convert-png-to-jpg',
    ]);
});

Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
Route::post('/invoice/generate', [InvoiceController::class, 'generate'])->name('invoice.generate');
});

Route::get('/testphp', function (Request $request) { 
   echo phpinfo();
});


Route::get('/login', function (Request $request) { 
    return response()->json([
        'message' => 'Unauthorized. Please login.'
    ], Response::HTTP_UNAUTHORIZED);
})->name('login');

 

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/sitemap-blog.xml', [SitemapController::class, 'index']);


Route::get('/uploadJpg', [JpgToPdfController::class, 'showUploadForm'])->name('upload.form');
Route::post('/upload', [JpgToPdfController::class, 'handleUpload'])->name('upload.handle');

Route::get('/editToPdf', [JpgToPdfController::class, 'showEditPage'])->name('edit.page');
Route::post('/convert', [JpgToPdfController::class, 'convertToPdf'])->name('convert.pdf');
Route::get('/privacy', function () {
    return view('privacy', [
        'breadCrumb' => 'Toolsborg Tools Online Center',
        'title' => 'Toolsborg Tools Online Center',
        'subtitle' => 'Manage your image files better and save on storage space by converting PNG files to JPG. Use our free PNG to JPG converter to touch up or edit your photos without lowering their quality or worrying about unnecessary watermarks. ',
        'actionUrl' => 'en/convert-png-to-jpg',
    ]);
});
// Route::get('/enhance', [ImageEnhanceController::class, 'index']);
// Route::post('/enhance', [ImageEnhanceController::class, 'enhance'])->name('enhance.process');