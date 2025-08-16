@extends('layouts.app', ['noFooter' => true])

@push('json-ld')
@php
  $ld = [
    '@context' => 'https://schema.org',
    '@type'    => 'WebPage',
    'name'        => 'Compress PDF — Toolsborg',   // ganti sesuai halaman
    'description' => 'Reduce PDF file size quickly and safely on Toolsborg.',
    'url'         => url()->current(),
    'mainEntity'  => [
      '@type'        => 'Action',
      'name'         => 'Compress PDF',
      'description'  => 'Upload a PDF and compress it by adjusting DPI and image quality.',
      'actionStatus' => 'PotentialActionStatus',
      'target'       => [
        '@type'         => 'EntryPoint',
        'urlTemplate'   => route('pdf.compress.form'),
        'inLanguage'    => 'id-ID',
        'actionPlatform'=> [
          'http://schema.org/DesktopWebPlatform',
          'http://schema.org/MobileWebPlatform'
        ],
      ],
      'object' => [
        '@type'          => 'MediaObject',
        'encodingFormat' => 'application/pdf',
      ],
      'result' => [
        '@type'          => 'MediaObject',
        'name'           => 'Compressed PDF',
        'encodingFormat' => 'application/pdf',
      ],
    ],
  ];
@endphp
<script type="application/ld+json">
{!! json_encode($ld, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush
@section('title', 'Compress PDF — Upload')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-emerald-500 to-green-700 text-white">
  <div class="max-w-5xl mx-auto px-4 py-16">
    {{-- Breadcrumbs gaya ringan --}}
    <div class="text-sm text-white/80 text-center mb-6">
      <span class="hover:underline">Home</span> ·
      <span class="hover:underline">PDF Editor</span> ·
      <span class="font-semibold text-white">Compress PDF</span>
    </div>

    <h1 class="text-center text-4xl md:text-5xl font-extrabold tracking-tight">
      Compress PDF Files
    </h1>

    {{-- Error dari server (validasi Laravel) --}}
    @if ($errors->any())
      <div class="max-w-xl mx-auto mt-6 bg-red-50/90 text-red-800 rounded-xl px-4 py-3">
        <ul class="list-disc ml-5">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('pdf.compress.upload') }}" method="POST" enctype="multipart/form-data"
          class="mt-10 flex flex-col items-center">
      @csrf

      {{-- Dropzone --}}
      <div id="dropzone"
           class="w-full max-w-lg border-2 border-white/70 border-dashed rounded-2xl bg-white/10 backdrop-blur-sm
                  px-8 py-14 text-center transition
                  hover:bg-white/15 hover:border-white
                  focus-within:ring-2 focus-within:ring-white/60">
        <input id="file-input" name="pdf" type="file" accept="application/pdf"
               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
        <div class="pointer-events-none">
          <div class="text-lg font-semibold">Upload your file</div>
          <div class="text-white/80 text-sm mt-1">or drop it here</div>
          <div id="file-name" class="mt-3 text-sm text-white/90"></div>
          <div id="file-hint" class="mt-1 text-xs text-white/70">PDF only · Max 50MB</div>
          <div id="file-error" class="mt-2 text-sm text-red-200 hidden"></div>
        </div>
      </div>

      {{-- CTA --}}
      <button id="submit-btn" type="submit"
              class="mt-8 bg-white text-emerald-700 font-semibold px-6 py-3 rounded-lg shadow
                     hover:shadow-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
        Compress PDF
      </button>

      {{-- sub text --}}
      <p class="mt-4 text-sm text-white/80 max-w-lg text-center">
        Reduce your PDF size quickly in your browser. No file is sent back to the server after upload.
      </p>
    </form>
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
    const dz        = document.getElementById('dropzone');
    const input     = document.getElementById('file-input');
    const nameEl    = document.getElementById('file-name');
    const errEl     = document.getElementById('file-error');
    const submitBtn = document.getElementById('submit-btn');
    const MAX_MB    = 50;

    function showError(msg){
      errEl.textContent = msg || '';
      errEl.classList.toggle('hidden', !msg);
    }
    function setFile(f){
      if (!f) { nameEl.textContent = ''; showError(''); submitBtn.disabled = true; return; }
      if (f.type !== 'application/pdf' && !f.name.toLowerCase().endsWith('.pdf')) {
        showError('File harus PDF (.pdf).'); submitBtn.disabled = true; return;
      }
      if (f.size > MAX_MB * 1024 * 1024) {
        showError(`Maksimal ${MAX_MB} MB.`); submitBtn.disabled = true; return;
      }
      nameEl.textContent = f.name;
      showError('');
      submitBtn.disabled = false;
    }

    // pilih via dialog
    input.addEventListener('change', () => setFile(input.files?.[0]));

    // drag & drop
    ;['dragenter','dragover'].forEach(evt => {
      dz.addEventListener(evt, (e) => {
        e.preventDefault(); e.stopPropagation();
        dz.classList.add('ring-2','ring-white/70','border-white');
      });
    });
    ;['dragleave','drop'].forEach(evt => {
      dz.addEventListener(evt, (e) => {
        e.preventDefault(); e.stopPropagation();
        dz.classList.remove('ring-2','ring-white/70','border-white');
      });
    });
    dz.addEventListener('drop', (e) => {
      const file = e.dataTransfer.files?.[0];
      if (!file) return;
      // set ke input agar form submit normal
      const dt = new DataTransfer();
      dt.items.add(file);
      input.files = dt.files;
      setFile(file);
    });

    // disable submit sampai file valid dipilih
    submitBtn.disabled = true;
  });
</script>
@endpush
@endsection
