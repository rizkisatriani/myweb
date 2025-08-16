<section id="features" class="relative bg-white py-20">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        {{-- Header --}}
        <header class="mx-auto mb-10 max-w-3xl text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                {{ $title ?? 'Every tool you need to work with documents' }}
            </h2>
            <p class="mt-3 text-gray-600">
                {{ $subtitle ?? 'Convert, merge, compress, edit, and generate QR codes — simple, fast, and free.' }}
            </p>
        </header>

        @php
        // === Your original list, now categorized + given gradients & short descriptions ===
        $tools = [
        // Image Tools
        ['label'=>'Merge PDF files','icon'=>'bi bi-intersect','url'=>'/en/pdf/merge','category'=>'documents','desc'=>'Combine multiple PDFs into one.','gradient'=>'from-rose-400 to-orange-500'],
        ['label'=>'Compress PDF Files','icon'=>'bi bi-file-earmark-zip','url'=>'/en/pdf/compress','category'=>'documents','desc'=>'Reduce file size without losing quality.','gradient'=>'from-emerald-400 to-green-600'],
        ['label'=>'Convert JPG To PDF','icon'=>'bi bi-filetype-pdf','url'=>'/en/convert-jpg-to-pdf','category'=>'images','desc'=>'Make clean PDFs from your JPG images in seconds.','gradient'=>'from-yellow-400 to-amber-500'],
        ['label'=>'Convert PNG To PDF','icon'=>'bi bi-filetype-pdf','url'=>'/en/convert-png-to-pdf','category'=>'images','desc'=>'Instantly convert PNG files into PDFs.','gradient'=>'from-cyan-400 to-sky-600'],

        ['label'=>'Convert PNG To JPG','icon'=>'bi bi-filetype-jpg','url'=>'/en/convert-png-to-jpg','category'=>'images','desc'=>'Turn PNG images into JPG for small size & wide support.','gradient'=>'from-amber-400 to-orange-500'],
        ['label'=>'Convert JPG To PNG','icon'=>'bi bi-filetype-png','url'=>'/en/convert-jpg-to-png','category'=>'images','desc'=>'Convert JPG to PNG for crisp graphics.','gradient'=>'from-sky-400 to-blue-500'],
        ['label'=>'Convert PNG To WEBP','icon'=>'bi bi-images','url'=>'/en/convert-png-to-webp','category'=>'images','desc'=>'Smaller images with modern WEBP format.','gradient'=>'from-teal-400 to-emerald-500'],

        // Document Tools
        ['label'=>'Convert Word To PDF','icon'=>'bi bi-file-earmark-word','url'=>'/en/convert-word-to-pdf','category'=>'documents','desc'=>'Share DOC/DOCX as PDF easily.','gradient'=>'from-blue-400 to-indigo-600'],
        ['label'=>'Convert PPT / PPTX To PDF','icon'=>'bi bi-filetype-ppt','url'=>'/en/convert-ppt-to-pdf','category'=>'documents','desc'=>'Export slides to PDF for easy viewing.','gradient'=>'from-orange-400 to-red-500'],
        ['label'=>'Invoice Generator','icon'=>'bi bi-receipt','url'=>'/en/invoice/create','category'=>'documents','desc'=>'Create professional invoices in minutes.','gradient'=>'from-purple-400 to-pink-500'],

        // QR Code Generator
        ['label'=>'Generate QR Code for URL','icon'=>'bi bi-qr-code','url'=>'/en/qrcode-generator-free','category'=>'qrcode','desc'=>'Make QR codes that link to any website.','gradient'=>'from-teal-400 to-cyan-500'],
        ['label'=>'Generate QR Code for Contact','icon'=>'bi bi-qr-code','url'=>'/en/contact-qrcode-generator-free','category'=>'qrcode','desc'=>'Create vCard QR codes for contacts.','gradient'=>'from-lime-400 to-green-500'],
       ];

        // Tabs
        $tabs = [
        'all' => 'All',
        'images' => 'Image Tools',
        'documents' => 'Document Tools',
        'qrcode' => 'QR Code',
        ];
        $active = request('cat', 'all'); // e.g. ?cat=images
        @endphp

        {{-- Tabs --}}
        <nav class="mb-8 flex flex-wrap items-center justify-center gap-3">
            @foreach($tabs as $key => $label)
            @php $isActive = ($active === $key); @endphp
            <a href="{{ url()->current() }}?cat={{ $key }}"
                class="rounded-full px-4 py-2 text-sm font-medium ring-1 transition
                  {{ $isActive ? 'bg-gray-900 text-white ring-gray-900'
                               : 'bg-white text-gray-700 ring-gray-300 hover:bg-gray-50' }}">
                {{ $label }}
            </a>
            @endforeach
        </nav>

        {{-- Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($tools as $tool)
            @if($active === 'all' || $tool['category'] === $active)
            <a href="{{ $tool['url'] }}"
                class="group relative overflow-hidden rounded-2xl p-6 transition
                    hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-gray-900/20">
                {{-- Gradient background --}}
                <div class="absolute inset-0 bg-gradient-to-br {{ $tool['gradient'] }} opacity-90"></div>
                {{-- Contrast overlay --}}
                <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition"></div>

                <div class="relative flex h-full flex-col text-white">
                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm">
                        <i class="{{ $tool['icon'] }} text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold">{{ $tool['label'] }}</h3>
                    <p class="mt-2 flex-grow text-sm text-white/90">{{ $tool['desc'] }}</p>
                    <span class="mt-4 inline-flex items-center text-sm font-medium">
                        Open tool <i class="bi bi-arrow-right ml-2"></i>
                    </span>
                </div>
            </a>
            @endif
            @endforeach
        </div>
    </div>

    {{-- soft bg flourish (optional) --}}
    <div class="pointer-events-none absolute inset-x-0 -top-10 -z-10 mx-auto h-40 max-w-7xl bg-gradient-to-r from-sky-100 via-emerald-100 to-rose-100 opacity-60 blur-3xl"></div>
</section>