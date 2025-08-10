@extends('layouts.app')

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