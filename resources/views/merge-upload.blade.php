@extends('layouts.app')
@push('json-ld')
@php
  $ld = [
    '@context' => 'https://schema.org',
    '@type'    => 'WebPage',
    'name'        => 'Merge PDF — Toolsborg',
    'description' => 'Merge multiple PDF files into a single PDF quickly and easily on Toolsborg.',
    'url'         => url()->current(),
    'mainEntity'  => [
      '@type'        => 'Action',
      'name'         => 'Merge PDF',
      'description'  => 'Upload multiple PDF files and merge them into one.',
      'actionStatus' => 'PotentialActionStatus',
      'target'       => [
        '@type'          => 'EntryPoint',
        'urlTemplate'    => route('pdf.merge.form'),
        'inLanguage'     => 'id-ID',
        'actionPlatform' => [
          'http://schema.org/DesktopWebPlatform',
          'http://schema.org/MobileWebPlatform',
        ],
      ],
      'object' => [
        '@type'          => 'MediaObject',
        'encodingFormat' => 'application/pdf',
      ],
      'result' => [
        '@type'          => 'MediaObject',
        'name'           => 'Merged PDF',
        'encodingFormat' => 'application/pdf',
      ],
    ],
  ];
@endphp
<script type="application/ld+json">
{!! json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush
@section('title', 'Merge PDF — Upload')

@section('content')
<section class="bg-gradient-to-br from-green-500 to-green-700 min-h-screen flex flex-col items-center justify-center text-white">
    <div class="max-w-screen-md mx-auto px-4 py-12 text-center">

        {{-- Breadcrumb --}}
        <div class="mb-4 text-sm text-green-200">
            <a href="/" class="hover:text-white transition">
                Home
            </a>
            <span class="mx-2">›</span>
            <a href="#" class="hover:text-white transition">PDF Editor</a>
            <span class="mx-2">›</span>
            <span class="font-semibold">Merge PDF</span>
        </div>

        {{-- Title --}}
        <h1 class="text-4xl md:text-5xl font-bold mb-6 flex items-center justify-center gap-2">
            Merge PDF Files
            <i class="bicon bicon-file-text text-white text-4xl"></i>
        </h1>

        {{-- Upload Area --}}
        <form action="{{ route('pdf.merge.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <label for="pdf-upload"
                class="flex flex-col items-center justify-center border-2 border-dashed border-green-300 rounded-lg p-10 bg-green-600/30 hover:bg-green-600/50 cursor-pointer transition">

                <i class="bicon bicon-upload text-white text-5xl mb-4"></i>
                <span class="text-lg font-semibold">Upload your file</span>
                <span class="text-green-200">or drop it here</span>
                <input id="pdf-upload" name="files[]" type="file" accept="application/pdf" multiple required class="hidden">
            </label>

            {{-- Preview Area --}}
            <div id="file-preview" class="text-sm text-green-200"></div>

            {{-- Submit Button --}}
            <div>
                <button type="submit" class="bg-white text-green-700 font-bold px-6 py-3 rounded-lg shadow-lg hover:bg-green-100 transition">
                    Merge PDF
                </button>
            </div>
        </form>

        {{-- Footer Note --}}
        <p class="mt-8 text-green-200 text-sm max-w-lg mx-auto">
            Merge multiple PDF files into one easily with our free online tool.
        </p>
    </div>
</section>
<x-pdf-tools
    title="Discover What You Can Do"
    subtitle="From converting images to editing documents, explore a full suite of tools designed to make your work faster and easier."
     />
<x-seo-section
    title="Change PDF to JPG files easily and for free"
    text="Want to add tear sheets to your online portfolio? Found an amazing vintage ad you want your followers to see? Scan important items from your archive of materials and transform them hassle-free into digital-friendly content. Upload riveting content on your website that people enjoy reading and viewing in high-quality images."
    image="/img/ilustration_1.jpg" />

<x-seo-section
    title="Access your content with editable PDF files"
    text="Make your documents picture-perfect. Use our PDF to JPG converter to adjust your content and enhance text and images. Your PDF file becomes editable, allowing you to apply filters and design elements to achieve an aesthetic effect."
    image="/img/ilustration_2.jpg"
    :reverse="true" />
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const uploadInput = document.getElementById('pdf-upload');
        const previewContainer = document.getElementById('file-preview');

        uploadInput.addEventListener('change', () => {
            const files = Array.from(uploadInput.files);
            previewContainer.innerHTML = files.length > 0 ?
                files.map(file => `📄 ${file.name}`).join('<br>') :
                '';
        });
    });
</script>
@endpush
@endsection