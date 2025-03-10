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
            ->generate(urldecode($request->text)); // Ganti dengan URL atau data yang ingin dikodekan

        $filename = 'qrcode.png';

        return Response::make($qrCode, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    
    public function downloadQRCodContact(Request $request)
    {
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

        $filename = 'qrcode.png';

        return Response::make($qrCode, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
