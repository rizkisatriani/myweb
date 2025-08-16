@extends('layouts.app')
@push('json-ld')
@php
  $ld = [
    '@context' => 'https://schema.org',
    '@type'    => 'WebPage',
    'name'        => 'Free QR Code Generator — Toolsborg',
    'description' => 'Create free QR codes for URL, text, Wi-Fi, contact (vCard), and more. Download PNG or SVG instantly.',
    'url'         => url()->current(),
    'isAccessibleForFree' => true,
    'mainEntity'  => [
      '@type'        => 'Action',
      'name'         => 'Generate QR Code',
      'description'  => 'Enter content (URL, text, Wi-Fi, vCard) and generate a QR code image.',
      'actionStatus' => 'PotentialActionStatus',
      'target'       => [
        '@type'          => 'EntryPoint',
        'urlTemplate'    => "{{ route('qr.generate.form') }}",
        'inLanguage'     => 'id-ID',
        'actionPlatform' => [
          'http://schema.org/DesktopWebPlatform',
          'http://schema.org/MobileWebPlatform'
        ]
      ],
      'result' => [
        '@type'          => 'ImageObject',
        'name'           => 'QR Code',
        'encodingFormat' => ['image/png', 'image/svg+xml']
      ]
    ]
  ];
@endphp
<script type="application/ld+json">
{!! json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('title', 'Toolsborg | Homepage')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center px-4">
    <div class="max-w-4xl w-full text-center">
        <!-- Breadcrumb -->
        <div class="text-sm text-purple-200 mb-6">
            <a href="#" class="hover:underline">Home</a> &gt;
            <a href="#" class="hover:underline">Photo Editor</a> &gt;
            <span class="font-semibold">Contact QR Code Generator</span>
        </div>

        <!-- Tabs -->
        <div class="flex justify-center gap-2 mb-6">
            <a href="{{ route('qrcode.generate', ['locale' => app()->getLocale()]) }}" 
               class="px-4 py-2 bg-purple-300 text-white rounded-lg hover:bg-purple-400">
               URL
            </a>
            <a href="{{ route('qrcode.generate_contact', ['locale' => app()->getLocale()]) }}" 
               class="px-4 py-2 bg-white text-purple-700 rounded-lg font-semibold">
               Contact/VCard
            </a>
            <a href="{{ route('qrcode.generate_wifi', ['locale' => app()->getLocale()]) }}" 
               class="px-4 py-2 bg-purple-300 text-white rounded-lg hover:bg-purple-400">
               WIFI
            </a>
        </div>

        <!-- Title -->
        <h1 class="text-4xl font-bold text-white mb-6">Contact QR Code Generator</h1>

        <!-- Input Form Box -->
        <div class="bg-white bg-opacity-10 border-2 border-dashed border-white rounded-lg p-8 mb-6">
            <form action="{{ route('qrcode.generate_contact', ['locale' => app()->getLocale()]) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="name" placeholder="Full Name" 
                       class="p-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-300"
                       value="{{ old('name',isset($name)?$name:'') }}" required>
                <input type="text" name="phone" placeholder="Phone Number" 
                       class="p-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-300"
                       value="{{ old('phone',isset($phone)?$phone:'') }}" required>
                <input type="email" name="email" placeholder="Email Address" 
                       class="p-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-300"
                       value="{{ old('email',isset($email)?$email:'') }}" required>
                <input type="text" name="address" placeholder="Address" 
                       class="p-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-300"
                       value="{{ old('address',isset($address)?$address:'') }}">
                
                <div class="md:col-span-2 flex justify-center">
                    <button type="submit" 
                            class="bg-white text-purple-700 font-semibold px-6 py-2 rounded-lg shadow hover:bg-purple-100">
                        Generate QR Code
                    </button>
                </div>
            </form>
        </div>

        <!-- QR Code Display -->
        @if($qrCode)
        <div class="bg-white bg-opacity-10 rounded-lg p-6 flex flex-col items-center gap-4">
            {!! $qrCode !!}
            <div class="flex gap-3">
                <a href="{{ $qrCodeDownloadUrl }}" 
                   class="bg-white text-purple-700 px-4 py-2 rounded-lg font-semibold hover:bg-purple-100">
                   Download JPG
                </a>
                <a href="{{ $qrCodePrintdUrl }}" 
                   class="bg-purple-300 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-400">
                   Print SVG/EPS
                </a>
            </div>
        </div>
        @endif
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