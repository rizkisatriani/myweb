@extends('layouts.app')
@push('json-ld')
@php
    // Kumpulkan gambar (featured + galeri jika ada)
    $images = array_values(array_filter(array_merge(
        [ $blog->featured_image ?? null ],
        is_array($blog->gallery_images ?? null) ? ($blog->gallery_images ?? []) : []
    )));

    // Author & publisher
    $authorName = $blog->author->name ?? $blog->author_name ?? 'Toolsborg Editorial';
    $authorUrl  = $blog->author->profile_url ?? null;
    $publisherName = config('app.name', 'Toolsborg');
    $publisherLogo = asset('logo.svg');

    // Tags & kategori (opsional)
    $tags       = method_exists($blog, 'tags')       ? ($blog->tags->pluck('name')->all() ?? [])       : [];
    $categories = method_exists($blog, 'categories') ? ($blog->categories->pluck('name')->all() ?? []) : [];

    // Body disingkat (agar JSON-LD tidak terlalu panjang)
    $plainBody = isset($blog->body) ? strip_tags($blog->body) : null;
    if ($plainBody && mb_strlen($plainBody) > 5000) {
        $plainBody = mb_substr($plainBody, 0, 5000);
    }
    $wordCount = $plainBody ? str_word_count($plainBody) : null;

    $ld = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BlogPosting',
        'headline'        => $blog->title,
        'description'     => $blog->excerpt ?? \Illuminate\Support\Str::limit($plainBody ?? '', 160),
        'mainEntityOfPage'=> ['@type' => 'WebPage', '@id' => url()->current()],
        'url'             => url()->current(),
        'image'           => $images ?: [asset('images/og-default.jpg')], // fallback opsional
        'datePublished'   => optional($blog->published_at)->toIso8601String(),
        'dateModified'    => optional($blog->updated_at)->toIso8601String(),
        'inLanguage'      => app()->getLocale() ?? 'id-ID',
        'isAccessibleForFree' => true,
        'author'          => array_filter([
            '@type' => 'Person',
            'name'  => $authorName,
            'url'   => $authorUrl,
        ]),
        'publisher'       => [
            '@type' => 'Organization',
            'name'  => $publisherName,
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => $publisherLogo,
            ],
        ],
        'keywords'        => $tags ? implode(', ', $tags) : null,
        'articleSection'  => $categories ? implode(', ', $categories) : null,
        'articleBody'     => $plainBody,
        'wordCount'       => $wordCount,
    ];

    // Hapus field null/kosong
    $ld = array_filter($ld, fn($v) => !is_null($v) && $v !== '');
@endphp
<script type="application/ld+json">
{!! json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush
@section('title', $blog->title)

@section('content')
<section class="bg-white">
    <div class="max-w-screen-xl mx-auto px-4 py-12 grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Kolom Kiri -->
        <div class="lg:col-span-2 hidden lg:block">
            <!-- Bisa diisi navigasi / kategori -->
        </div>

        <!-- Kolom Tengah (Konten Blog) -->
        <div class="lg:col-span-7">
            <div class="mb-4 text-sm text-gray-600 mt-6">
                <a href="{{ route('blogs.index') }}" class="text-gray-500 hover:text-purple-600">← Back to Blog</a>
            </div>
            <h1 class="text-3xl font-bold mb-4">{{ $blog->title }}</h1>
            <p class="text-gray-500 text-sm mb-4">Published on {{ $blog->published_at->format('F j, Y') }}</p>
            @if ($blog->featured_image)
            <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-full mb-6 rounded-lg">
            @endif
            <article class="prose max-w-none">
                {!! $blog->content !!}
            </article>
        </div>

        <!-- Kolom Kanan (Sticky Card) -->
        <div class="lg:col-span-3">
            <div class="sticky top-24">
                <div class="bg-gray-100 rounded-lg shadow-xl">
                    <img class="" src="{{ asset('images/banner_pdf.jpg') }}" alt="hero image">
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-4">Turn Your Images into PDF Instantly!</h2>
                        <p class="text-gray-600 mb-4">Convert photos, illustrations, or scanned documents into high-quality PDFs in seconds—fast, easy, and secure.</p>
                        <a href="/en/convert-jpg-to-pdf" class="block bg-purple-600 text-white px-4 py-2 rounded-lg text-center hover:bg-purple-700">
                            Convert Now
                        </a> 
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection