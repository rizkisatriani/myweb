@extends('layouts.app')

@section('title', 'Toolsborg | Homepage')

@section('content')
<section class="bg-white ">
    <div class=" max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="container mx-auto">
            <!-- Breadcrumb -->
            <div class="text-sm text-gray-600 mb-4">
                <a href="#" class="text-gray-500 hover:text-purple-600">Home</a> &gt;
                <a href="#" class="text-gray-500 hover:text-purple-600">Photo Editor</a> &gt;
                <span class="text-purple-800 font-semibold">{{$breadCrumb}}</span>
            </div>

            <div class="flex space-x-2 p-2"> 
                <a href="{{ route('qrcode.generate', ['locale' => app()->getLocale()]) }}" class="px-4 py-2 bg-gray-200 text-black rounded-lg">URL</a>
                <a href="{{ route('qrcode.generate_contact', ['locale' => app()->getLocale()]) }}" class="px-4 py-2 text-black rounded-lg bg-gray-900 text-white">Contact/VCard</a>
                <a href="{{ route('qrcode.generate_wifi', ['locale' => app()->getLocale()]) }}" class="px-4 py-2 bg-gray-200 text-black rounded-lg">WIFI</a>
            </div>
            <!-- Main Section -->
            <div class="relative bg-gray-100 rounded-lg p-4">
                <!-- Background Decorations -->
                <div class="absolute top-0 left-0 w-16 h-16 bg-red-100 rounded-full transform -translate-x-4 -translate-y-4"></div>
                <div class="absolute bottom-0 right-0 w-20 h-20 bg-purple-300 rounded-full transform translate-x-4 translate-y-4"></div>
                <div class="relative max-w-4xl mx-auto bg-white shadow rounded-lg p-6 flex flex-col lg:flex-col gap-6">
                    <h1 class="text-3xl font-bold">Contact QR Code Generator</h1>
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- Left Section - Input and Options -->
                        <div class="w-full lg:w-1/2">
                            <h2 class="font-semibold mb-4">Enter Contact Details</h2>
                            <form action="{{ route('qrcode.generate_contact', ['locale' => app()->getLocale()]) }}" method="POST">
                                @csrf
                                <input type="text" name="name" placeholder="Full Name" class="w-full p-2 border rounded-lg mb-4" value="{{ old('name',isset($name)?$name:'') }}" required>
                                <input type="text" name="phone" placeholder="Phone Number" class="w-full p-2 border rounded-lg mb-4" value="{{ old('phone',isset($phone)?$phone:'') }}" required>
                                <input type="email" name="email" placeholder="Email Address" class="w-full p-2 border rounded-lg mb-4" value="{{ old('email',isset($email)?$email:'') }}" required>
                                <input type="text" name="address" placeholder="Address" class="w-full p-2 border rounded-lg mb-4" value="{{ old('address',isset($address)?$address:'') }}">
                                <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 sm:mr-2 lg:mr-0 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800">Generate QR Code</button>
                            </form>
                        </div>
                        <!-- Right Section - QR Code Display -->
                        <div class="w-full lg:w-1/2 shadow flex justify-center items-center">
                            @if($qrCode)
                            <div class="p-4 border rounded-lg bg-gray-100 text-center flex flex-col items-center">
                                {!! $qrCode !!}
                                <div class="mt-4 flex gap-2">
                                    <a href="{{ $qrCodeDownloadUrl }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Download JPG</a>
                                    <a href="{{ $qrCodePrintdUrl }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Print SVG/EPS</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@php
$tools = [
    // Images Tools
    ['label' => 'Convert PNG To JPG', 'icon' => 'bi bi-filetype-jpg', 'url' => '/en/convert-png-to-jpg'],
    ['label' => 'Convert JPG To PNG', 'icon' => 'bi bi-filetype-png', 'url' => '/en/convert-jpg-to-png'],
    ['label' => 'Convert JPG To PDF', 'icon' => 'bi bi-filetype-pdf', 'url' => '/en/convert-jpg-to-pdf'],
    ['label' => 'Convert PNG To PDF', 'icon' => 'bi bi-filetype-pdf', 'url' => '/en/convert-png-to-pdf'],
    ['label' => 'Convert PNG To WEBP', 'icon' => 'bi bi-images', 'url' => '/en/convert-png-to-webp'],

    // Document Tools
    ['label' => 'Convert Word To PDF', 'icon' => 'bi bi-file-earmark-word', 'url' => '/en/convert-word-to-pdf'],
    ['label' => 'Convert PPT / PPTX To PDF', 'icon' => 'bi bi-filetype-ppt', 'url' => '/en/convert-ppt-to-pdf'],
    ['label' => 'Invoice Generator', 'icon' => 'bi bi-receipt', 'url' => '/en/invoice/create'],

    // QR Code Generator
    ['label' => 'Generate QR Code for URL', 'icon' => 'bi bi-qr-code', 'url' => '/en/qrcode-generator-free'],
    ['label' => 'Generate QR Code for Contact', 'icon' => 'bi bi-qr-code', 'url' => '/en/contact-qrcode-generator-free'],
    ['label' => 'Generate QR Code for WiFi', 'icon' => 'bi bi-qr-code', 'url' => '/en/contact-qrcode-generator-free'],
];
@endphp
<x-pdf-tools 
    title="Discover What You Can Do" 
    subtitle="From converting images to editing documents, explore a full suite of tools designed to make your work faster and easier."
    :tools="$tools"
/>
<x-seo-section 
    title="Change PDF to JPG files easily and for free"
    text="Want to add tear sheets to your online portfolio? Found an amazing vintage ad you want your followers to see? Scan important items from your archive of materials and transform them hassle-free into digital-friendly content. Upload riveting content on your website that people enjoy reading and viewing in high-quality images."
    image="/img/ilustration_1.jpg"
/>

<x-seo-section 
    title="Access your content with editable PDF files"
    text="Make your documents picture-perfect. Use our PDF to JPG converter to adjust your content and enhance text and images. Your PDF file becomes editable, allowing you to apply filters and design elements to achieve an aesthetic effect."
    image="/img/ilustration_2.jpg"
    :reverse="true"
/>
@endsection