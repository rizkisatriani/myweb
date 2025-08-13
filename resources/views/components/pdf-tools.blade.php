<div class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-bold text-center text-purple-700 mb-2">
            {{ $title ?? 'Try these document editing tools' }}
        </h2>
        <p class="text-center text-gray-500 mb-10">
            {{ $subtitle ?? 'Edit, convert, translate PDFs and more. All the PDF editing tools you need!' }}
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($tools as $tool)
                <a href="{{ $tool['url'] ?? '#' }}" 
                   class="flex items-center gap-3 p-4 bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg transition">
                    <i class="{{ $tool['icon'] }} text-purple-600 text-xl"></i>
                    <span class="font-semibold text-purple-700">{{ $tool['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
