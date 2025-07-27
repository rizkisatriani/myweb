@extends('layouts.app')

@section('title', $blog->title)

@section('content')
<section class="bg-white">
    <div class="max-w-screen-md mx-auto px-4 py-12">
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
</section>
@endsection
