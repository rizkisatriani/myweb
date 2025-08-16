@extends('layouts.app')
@push('json-ld')
@php
  // Organization
  $orgLd = [
    '@context' => 'https://schema.org',
    '@type'    => 'Organization',
    'name'        => 'Toolsborg',
    'url'         => url('/'),
    'logo'        => url('/logo.svg'),
    'description' => 'Toolsborg Tools Online Center. Simplify your workday with a suite of powerful online tools — from image and document converters to enterprise-grade speed testing. Boost productivity, streamline tasks, and save time!',
    'sameAs'      => [
      'https://web.facebook.com/profile.php?id=61579608146349',
      'https://www.instagram.com/toolsborg'
    ],
    'contactPoint' => [
      '@type'             => 'ContactPoint',
      'email'             => 'admin@toolsborg.com',
      'contactType'       => 'customer service',
      'areaServed'        => 'ID',
      'availableLanguage' => ['Indonesian','English'],
    ],
  ];

  // WebSite (+ SearchAction opsional)
  $siteLd = [
    '@context' => 'https://schema.org',
    '@type'    => 'WebSite',
    'name'     => 'Toolsborg',
    'url'      => url('/'),
    // Hapus blok ini jika tidak ada halaman pencarian
    'potentialAction' => [
      '@type'       => 'SearchAction',
      'target'      => url('/search') . '?q={search_term_string}',
      'query-input' => 'required name=search_term_string',
    ],
  ];
@endphp

<script type="application/ld+json">
{!! json_encode($orgLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

<script type="application/ld+json">
{!! json_encode($siteLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('title', 'Adsdigi | Homepage')

@section('content')

<section class="relative overflow-hidden bg-sky-50">
  <div class="mx-auto max-w-7xl px-6 py-16 lg:py-24">
    <div class="grid items-center gap-10 lg:grid-cols-12">
      {{-- Left: copy + CTAs --}}
      <div class="lg:col-span-7">
        <span class="inline-flex items-center rounded-full bg-sky-100 px-3 py-1 text-xs font-medium text-sky-700 ring-1 ring-sky-200">
          <i class="bi bi-lightning-charge-fill mr-2"></i> Fast, Secure & Free
        </span>

        <h1 class="mt-5 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">
          Your All-in-One PDF Toolkit
        </h1>

        <p class="mt-4 text-lg text-slate-600">
          Convert images to PDF, merge multiple documents, and compress files — all in one simple, secure, and powerful tool.
        </p>

        <div class="mt-8 flex flex-wrap gap-3">
          <a href="#features"
             class="inline-flex items-center rounded-xl bg-sky-600 px-5 py-3 text-white shadow-sm hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-600 focus:ring-offset-2">
            <i class="bi bi-rocket-takeoff mr-2"></i> Start for Free
          </a>
          <a href="#features"
             class="inline-flex items-center rounded-xl px-5 py-3 text-slate-700 ring-1 ring-slate-300 hover:bg-white/60 focus:outline-none focus:ring-2 focus:ring-slate-300">
            <i class="bi bi-grid mr-2"></i> Explore Features
          </a>
        </div>

        {{-- Feature highlights --}}
        <div id="" class="mt-10 grid gap-4 sm:grid-cols-3">
          <div class="flex items-start gap-3 rounded-2xl bg-white p-4 ring-1 ring-slate-200">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100 text-sky-700">
              <i class="bi bi-file-earmark-image"></i>
            </div>
            <div>
              <p class="font-semibold text-slate-900">Convert JPG to PDF</p>
              <p class="text-sm text-slate-600">Turn images into professional PDFs instantly.</p>
            </div>
          </div>

          <div class="flex items-start gap-3 rounded-2xl bg-white p-4 ring-1 ring-slate-200">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
              <i class="bi bi-files-alt"></i>
            </div>
            <div>
              <p class="font-semibold text-slate-900">Merge PDF</p>
              <p class="text-sm text-slate-600">Combine multiple files into one clean document.</p>
            </div>
          </div>

          <div class="flex items-start gap-3 rounded-2xl bg-white p-4 ring-1 ring-slate-200">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-violet-700">
              <i class="bi bi-arrows-collapse"></i>
            </div>
            <div>
              <p class="font-semibold text-slate-900">Compress PDF</p>
              <p class="text-sm text-slate-600">Reduce size without losing quality.</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Right: visual cards --}}
      <div class="lg:col-span-5">
        <div class="grid gap-6">
          {{-- Card: Quick action / growth feel --}}
          <div class="rounded-3xl bg-sky-600 p-6 text-white shadow-xl">
            <h3 class="text-xl font-semibold">Work smarter with PDFs</h3>
            <p class="mt-1 text-sm text-sky-100">Clean results, ready for school, office, or legal use.</p>

            <div class="relative mt-6 h-36 rounded-2xl bg-white/5 p-4">
              {{-- Simple chart look --}}
              <svg viewBox="0 0 200 80" class="h-full w-full text-white/90" aria-hidden="true">
                <polyline fill="none" stroke="currentColor" stroke-width="2"
                          points="0,60 35,52 70,56 105,40 140,45 175,30 200,20" />
                <circle cx="200" cy="20" r="4" fill="currentColor"/>
              </svg>
              <span class="absolute right-3 top-3 inline-flex items-center gap-1 rounded-full bg-emerald-500/90 px-2 py-1 text-xs font-semibold text-white">
                <i class="bi bi-arrow-up-right"></i> +46% faster
              </span>
            </div>
          </div>

          {{-- Card: quick signup/CTA --}}
          <div class="rounded-3xl bg-slate-900 p-6 text-white shadow-xl">
            <h3 class="text-xl font-semibold">Start a session</h3>
            <p class="mt-1 text-sm text-slate-300">Try a quick conversion right now.</p>

            <div class="mt-4 flex items-center">
              <i class="bi bi-shield-check mr-2 text-emerald-400"></i>
              <span class="text-sm text-slate-300">Secure & compliant</span>
            </div>

            <a href="#features"
               class="mt-6 inline-flex items-center rounded-xl bg-white px-4 py-2 text-slate-900 hover:bg-slate-100">
              <i class="bi bi-mouse2 mr-2"></i> Convert a file
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- background accent --}}
  <div class="pointer-events-none absolute inset-y-0 right-0 -z-10 w-[50%] bg-gradient-to-bl from-sky-100 to-transparent"></div>
</section>
<section class="bg-white">
  <div class="mx-auto max-w-7xl px-6 py-16">
    {{-- Small label --}}
    <div class="mb-3">
      <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 ring-1 ring-emerald-200">
        WHY CHOOSE US
      </span>
    </div>

    {{-- Heading --}}
    <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
      Why <span class="text-emerald-600">Toolsborg</span> is the Right Choice for You
    </h2>

    <div class="mt-10 grid gap-6 lg:grid-cols-12">
      {{-- LEFT: 3 light cards --}}
      <div class="lg:col-span-7 grid gap-6">
        <div class="grid gap-6 sm:grid-cols-2">
          {{-- Card 1 --}}
          <article class="rounded-2xl bg-slate-50 p-6 ring-1 ring-slate-200">
            <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100 text-sky-700">
              <i class="bi bi-file-earmark-image"></i>
            </div>
            <h3 class="text-lg font-semibold text-slate-900">Convert with Ease</h3>
            <p class="mt-1 text-sm text-slate-600">
              Turn JPG images into professional PDFs in seconds — perfect for students, office work, and quick tasks.
            </p>
          </article>

          {{-- Card 2 --}}
          <article class="rounded-2xl bg-slate-50 p-6 ring-1 ring-slate-200">
            <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700">
              <i class="bi bi-files"></i>
            </div>
            <h3 class="text-lg font-semibold text-slate-900">Merge Without Hassle</h3>
            <p class="mt-1 text-sm text-slate-600">
              Combine multiple PDFs into one clean document — no ads, no hidden paywalls.
            </p>
          </article>
        </div>

        {{-- Card 3 full width --}}
        <article class="rounded-2xl bg-slate-50 p-6 ring-1 ring-slate-200">
          <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700">
            <i class="bi bi-shield-check"></i>
          </div>
          <h3 class="text-lg font-semibold text-slate-900">Secure Compression</h3>
          <p class="mt-1 text-sm text-slate-600">
            Shrink large files without losing readability — ideal for email, legal portals, and student submissions.
          </p>
          <ul class="mt-3 list-inside list-disc text-sm text-slate-600">
            <li>Save upload time & bandwidth</li>
            <li>No watermarks, privacy guaranteed</li>
          </ul>
        </article>
      </div>

      {{-- RIGHT: image background card (pain points) --}}
      <div class="lg:col-span-5">
        <article class="relative overflow-hidden rounded-3xl shadow-xl">
          {{-- Replace with your own illustration --}}
          <div
            class="bg-cover bg-center"
            style="background-image: url('{{ asset('images/why.jpg') }}');"
          >
            {{-- Dark overlay --}}
            <div class="relative z-10 h-full w-full bg-slate-900/60 p-6 sm:p-8">
              <h3 class="text-2xl font-semibold text-white">The Everyday Struggles We Solve</h3>
              <p class="mt-2 max-w-md text-sm text-slate-200">
                Tight deadlines, scattered files, oversized PDFs — sound familiar?
              </p>

              <ul class="mt-5 space-y-3 text-sm text-slate-100">
                <li class="flex items-start gap-3">
                  <i class="bi bi-alarm mt-0.5 text-emerald-400"></i>
                  <span><span class="font-medium">Students:</span> rushing to convert assignments to PDF before midnight deadlines.</span>
                </li>
                <li class="flex items-start gap-3">
                  <i class="bi bi-diagram-3 mt-0.5 text-emerald-400"></i>
                  <span><span class="font-medium">Office workers:</span> piecing together multiple reports into one file.</span>
                </li>
                <li class="flex items-start gap-3">
                  <i class="bi bi-shield-lock mt-0.5 text-emerald-400"></i>
                  <span><span class="font-medium">Legal professionals:</span> compressing heavy case files to share securely.</span>
                </li>
              </ul>

              <a href="#features"
                 class="mt-6 inline-flex items-center rounded-xl bg-white px-4 py-2 text-slate-900 hover:bg-slate-100">
                <i class="bi bi-rocket-takeoff mr-2"></i> Start for Free
              </a>
            </div>

            {{-- Spacer to maintain height --}}
            <div class="pointer-events-none h-80 sm:h-96"></div>
          </div>

          {{-- Decorative gradient edge --}}
          <div class="absolute inset-0 bg-gradient-to-tr from-emerald-500/0 via-emerald-500/0 to-emerald-500/10"></div>
        </article>
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
<section class="bg-white">
  <div class="py-20 sm:py-28">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      {{-- Heading --}}
      <div class="mx-auto max-w-3xl text-center">
        <h2 class="text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
          Explore Our Latest Insights
        </h2>
        <p class="mt-3 text-lg text-gray-600">
          Dive into tips, stories, and guides curated by our team.
        </p>
      </div>

      @php
        $featured = $blogs->first();
        $others   = $blogs->slice(1, 3); // ambil 3 berikutnya
      @endphp

      @if($featured)
      {{-- FEATURED CARD (image left, text right) --}}
      <article
        onclick="window.location='{{ route('blogs.show', $featured->slug) }}'"
        class="mt-12 grid cursor-pointer overflow-hidden rounded-3xl bg-gray-50 ring-1 ring-gray-200 transition hover:shadow-xl lg:grid-cols-2"
      >
        {{-- left image --}}
        <div class="relative">
          @if ($featured->featured_image)
            <img
              src="{{ $featured->featured_image }}"
              alt="{{ $featured->title }}"
              class="h-full w-full object-cover"
            >
          @else
            <div class="aspect-[16/10] h-full w-full bg-gray-200"></div>
          @endif
          {{-- rounded corner mask on large screens --}}
          <div class="pointer-events-none absolute inset-0 rounded-3xl lg:rounded-r-none"></div>
        </div>

        {{-- right text panel --}}
        <div class="flex flex-col justify-between p-8 sm:p-10">
          <div>
            <div class="flex items-center gap-3 text-xs">
              <time class="text-gray-500">
                {{ optional($featured->published_at)->format('F j, Y') }}
              </time>
              @if($featured->featured_image)
                <span class="capitalize rounded-full bg-emerald-50 px-3 py-1.5 font-medium text-emerald-700 ring-1 ring-emerald-200">
                  {{ pathinfo($featured->featured_image, PATHINFO_FILENAME) }}
                </span>
              @endif
            </div>

            <h3 class="mt-4 text-2xl font-semibold leading-snug text-gray-900 transition group-hover:text-gray-700">
              {{ $featured->title }}
            </h3>
            <p class="mt-3 line-clamp-3 text-gray-600">
              {{ Str::limit(strip_tags($featured->excerpt), 160) }}
            </p>
          </div>

          <div class="mt-6 flex items-center gap-3">
            <a href="{{ route('blogs.show', $featured->slug) }}"
               class="inline-flex items-center rounded-xl bg-gray-900 px-4 py-2 text-white hover:bg-gray-800">
              Read Article
              <svg class="ml-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 11-1.414-1.414L13.586 10H4a1 1 0 110-2h9.586l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
              </svg>
            </a>
          </div>
        </div>
      </article>
      @endif

      {{-- 3 SMALL CARDS --}}
      @if($others->count())
      <div class="mt-10 grid gap-6 sm:mt-12 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($others as $blog)
          <article
            onclick="window.location='{{ route('blogs.show', $blog->slug) }}'"
            class="group cursor-pointer overflow-hidden rounded-2xl ring-1 ring-gray-200 transition hover:shadow-lg"
          >
            {{-- image --}}
            @if ($blog->featured_image)
              <div class="relative">
                <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="h-56 w-full object-cover">
                <span class="absolute left-3 top-3 rounded-full bg-black/60 px-2.5 py-1 text-xs text-white backdrop-blur-sm">
                  {{ pathinfo($blog->featured_image, PATHINFO_FILENAME) }}
                </span>
              </div>
            @else
              <div class="h-56 w-full bg-gray-200"></div>
            @endif

            {{-- text --}}
            <div class="p-5 bg-white">
              <time class="text-xs text-gray-500">
                {{ optional($blog->published_at)->format('F j, Y') }}
              </time>
              <h3 class="mt-2 text-base font-semibold text-gray-900 transition group-hover:text-gray-700">
                {{ $blog->title }}
              </h3>
              <p class="mt-2 line-clamp-2 text-sm text-gray-600">
                {{ Str::limit(strip_tags($blog->excerpt), 100) }}
              </p>
              <div class="mt-4 flex items-center text-sm font-medium text-emerald-600 group-hover:underline">
                Read more
                <svg class="ml-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 11-1.414-1.414L13.586 10H4a1 1 0 110-2h9.586l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
          </article>
        @endforeach
      </div>
      @endif
    </div>
  </div>
</section>


@endsection