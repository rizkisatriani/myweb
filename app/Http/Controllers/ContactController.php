<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('contact', [
        'breadCrumb' => 'Contact',
        'title' => 'Contact Us',
        'subtitle' => 'Contact Us',
        'actionUrl' => null, 
    ]);
    }

    public function store(Request $request)
    {
  // Validasi data
    $request->validate([
        'first_name' => 'required|string|max:50',
        'last_name'  => 'required|string|max:50',
        'email'      => 'required|email|max:100',
        'message'    => 'required|string|max:1000',
    ]);

    // Gabungkan first_name dan last_name menjadi name
    $fullName = $request->first_name . ' ' . $request->last_name;

    // Simpan ke database
    ContactRequest::create([
        'name'    => $fullName,
        'email'   => $request->email,
        'message' => $request->message,
    ]);

    return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }
}
