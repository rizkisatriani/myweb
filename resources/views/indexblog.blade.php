@extends('layouts.app')

@section('title', 'Toolsborg | Blog')

@section('content')
<section class="bg-white">
    <div class="max-w-screen-xl px-4 py-12 mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center mt-6">Latest Blog Articles</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($blogs as $blog)
            <a href="{{ route('blogs.show', $blog->slug) }}" class="block bg-white shadow rounded-lg overflow-hidden hover:shadow-md transition">
                @if ($blog->featured_image)
                    <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $blog->title }}</h2>
                    <p class="text-gray-600 text-sm mb-2">{{ $blog->published_at->format('F j, Y') }}</p>
                    <p class="text-gray-700 text-sm">{{ Str::limit(strip_tags($blog->excerpt), 100) }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $blogs->links() }}
        </div>
    </div>
</section>
@endsection
