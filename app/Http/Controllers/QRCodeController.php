<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function downloadQRCodeUrl(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
        ]);
    
        $qrCode = QrCode::format('png')
            ->size(300)
            ->generate($request->text); // Ganti dengan URL atau data yang ingin dikodekan

        $filename = 'qrcode.png';

        return Response::make($qrCode, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
