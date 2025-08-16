@extends('layouts.app')
@push('json-ld')
@php
  $ld = [
    '@context' => 'https://schema.org',
    '@type'    => 'WebPage',
    'name'        => 'Convert JPG to PDF — Toolsborg',
    'description' => 'Convert your JPG images to a single PDF quickly and safely on Toolsborg.',
    'url'         => url()->current(),
    'isAccessibleForFree' => true,
    'mainEntity'  => [
      '@type'        => 'Action',
      'name'         => 'Convert JPG to PDF',
      'description'  => 'Upload one or more JPG images and convert them into a PDF file.',
      'actionStatus' => 'PotentialActionStatus',
      'target'       => [
        '@type'          => 'EntryPoint',
        'urlTemplate'    => "{{ route('jpg2pdf.form') }}", // ganti sesuai nama route form kamu
        'inLanguage'     => 'id-ID',
        'actionPlatform' => [
          'http://schema.org/DesktopWebPlatform',
          'http://schema.org/MobileWebPlatform'
        ]
      ],
      'object' => [
        '@type'          => 'ImageObject',
        'encodingFormat' => ['image/jpeg','image/jpg']
      ],
      'result' => [
        '@type'          => 'MediaObject',
        'name'           => 'PDF document',
        'encodingFormat' => 'application/pdf'
      ]
    ]
  ];
@endphp
<script type="application/ld+json">
{!! json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<section class="bg-gradient-to-br from-purple-500 to-purple-700 min-h-screen flex flex-col items-center justify-center text-white">
    <div class="max-w-screen-md mx-auto px-4 py-12 text-center">
        
        {{-- Breadcrumb --}}
        <div class="mb-4 text-sm text-purple-200">
            <a href="/" class="hover:text-white transition">
                Home
            </a>
            <span class="mx-2">›</span>
            <a href="#" class="hover:text-white transition">PDF Editor</a>
            <span class="mx-2">›</span>
            <span class="font-semibold">JPG to PDF</span>
        </div>

        {{-- Title --}}
        <h1 class="text-4xl md:text-5xl font-bold mb-6 flex items-center justify-center gap-2">
            Free JPG to PDF Converter
            <i class="bicon bicon-file-text text-white text-4xl"></i>
        </h1>

        {{-- Upload Area --}}
        <form action="{{ route('upload.handle') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <label for="image-upload" 
                class="flex flex-col items-center justify-center border-2 border-dashed border-purple-300 rounded-lg p-10 bg-purple-600/30 hover:bg-purple-600/50 cursor-pointer transition">
                
                <i class="bicon bicon-upload text-white text-5xl mb-4"></i>
                <span class="text-lg font-semibold">Upload your file</span>
                <span class="text-purple-200">or drop it here</span>
                <input id="image-upload" name="images[]" type="file" accept="image/*" multiple required class="hidden">
            </label>

            {{-- Preview Area --}}
            <div id="file-preview" class="text-sm text-purple-200"></div>

            {{-- Submit Button --}}
            <div>
                <button type="submit" class="bg-white text-purple-700 font-bold px-6 py-3 rounded-lg shadow-lg hover:bg-purple-100 transition">
                    Convert to PDF
                </button>
            </div>
        </form>

        {{-- Footer Note --}}
        <p class="mt-8 text-purple-200 text-sm max-w-lg mx-auto">
            Pictures and videos make for great content but don’t forget about documents like reports and records in their usual PDF files, too. 
            Convert JPG to PDF easily with our free online converter.
        </p>
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
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const uploadInput = document.getElementById('image-upload');
        const previewContainer = document.getElementById('file-preview');

        uploadInput.addEventListener('change', () => {
            const files = Array.from(uploadInput.files);
            previewContainer.innerHTML = files.length > 0 
                ? files.map(file => `📄 ${file.name}`).join('<br>') 
                : '';
        });
    });
</script>
@endpush
@endsection
