<div class="bg-white py-16">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-bold text-center text-purple-700 mb-2">
            {{ $title ?? 'Try these document editing tools' }}
        </h2>
        <p class="text-center text-gray-500 mb-10">
            {{ $subtitle ?? 'Edit, convert, translate PDFs and more. All the PDF editing tools you need!' }}
        </p>
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
        ['label' => 'Merge PDF files', 'icon' => 'bi bi-intersect', 'url' => '/en/pdf/merge'],
        ['label' => 'Compress PDF Files', 'icon' => 'bi bi-file-earmark-zip', 'url' => '/en/pdf/compress'],
        ['label' => 'Invoice Generator', 'icon' => 'bi bi-receipt', 'url' => '/en/invoice/create'],

        // QR Code Generator
        ['label' => 'Generate QR Code for URL', 'icon' => 'bi bi-qr-code', 'url' => '/en/qrcode-generator-free'],
        ['label' => 'Generate QR Code for Contact', 'icon' => 'bi bi-qr-code', 'url' => '/en/contact-qrcode-generator-free'],
        ['label' => 'Generate QR Code for WiFi', 'icon' => 'bi bi-qr-code', 'url' => '/en/contact-qrcode-generator-free'],
        ];
        @endphp
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
