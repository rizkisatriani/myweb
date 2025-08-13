@props([
    'title' => '',
    'text' => '',
    'image' => '',
    'reverse' => false // true = image right, text left
])

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        
        {{-- Image --}}
        <div class="{{ $reverse ? 'md:order-2' : '' }}">
            <img src="{{ $image }}" alt="{{ $title }}" class="rounded-lg shadow-lg w-full">
        </div>

        {{-- Text --}}
        <div class="{{ $reverse ? 'md:order-1' : '' }}">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ $title }}</h2>
            <p class="text-gray-600 leading-relaxed">
                {{ $text }}
            </p>
        </div>

    </div>
</section>
