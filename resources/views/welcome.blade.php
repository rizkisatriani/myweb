@extends('layouts.app')
@push('json-ld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Toolsborg",
  "url": "https://toolsborg.com",
  "logo": "https://toolsborg.com/logo.svg",
  "description": "Toolsborg Tools Online Center. Simplify your workday with a suite of powerful online tools — from image and document converters to enterprise-grade speed testing. Boost productivity, streamline tasks, and save time!",
  "sameAs": [
    "https://web.facebook.com/profile.php?id=61579608146349",
    "https://www.instagram.com/toolsborg",
  ],
  "contactPoint": {
    "@type": "ContactPoint",
    "email": "admin@toolsborg.com",
    "contactType": "customer service",
    "areaServed": "ID",
    "availableLanguage": ["Indonesian","English"]
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "Toolsborg",
  "url": "https://toolsborg.com",
}
</script>

@endpush
@section('title', 'Adsdigi | Homepage')

@section('content')

<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="mr-auto place-self-center lg:col-span-7">
            <h1 class="max-w-2xl mb-4 text-4xl font-extrabold leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white">Toolsborg <br>Tools Online Center.</h1>
            <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">Simplify your workday with a suite of powerful online tools — from image and document converters to enterprise-grade speed testing. Boost productivity, streamline tasks, and save time! </p>
            <div class="space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                <a href="https://www.youtube.com/@programmerninja1950" target="_blank" class="inline-flex items-center justify-center w-full px-5 py-3 text-sm font-medium text-center text-gray-900 border border-gray-200 rounded-lg sm:w-auto hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                    <svg class="w-4 h-4 mr-2" height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 461.00 461.00" xml:space="preserve" fill="#000000" stroke="#000000" stroke-width="0.0046100099999999995">

                        <g id="SVGRepo_bgCarrier" stroke-width="0" />

                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="1.844004" />

                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <path style="fill:#F61C0D;" d="M365.257,67.393H95.744C42.866,67.393,0,110.259,0,163.137v134.728 c0,52.878,42.866,95.744,95.744,95.744h269.513c52.878,0,95.744-42.866,95.744-95.744V163.137 C461.001,110.259,418.135,67.393,365.257,67.393z M300.506,237.056l-126.06,60.123c-3.359,1.602-7.239-0.847-7.239-4.568V168.607 c0-3.774,3.982-6.22,7.348-4.514l126.06,63.881C304.363,229.873,304.298,235.248,300.506,237.056z" />
                            </g>
                        </g>

                    </svg>Subscribe Our Youtube
                </a>

            </div>
        </div>
        <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
            <img class="absolute top-0 right-0" src="{{ asset('images/bg_top.webp') }}" alt="hero image">
        </div>
    </div>
</section>

<section class="bg-white dark:bg-gray-900">
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base/7 font-semibold text-indigo-600">Complete tools</h2>
                <p class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl lg:text-balance">Boost Efficiency with Our Powerful Features!</p>
                <p class="mt-6 text-lg/8 text-gray-700">Discover the best digital solutions meticulously crafted to meet your unique needs,
                    whether you're managing personal tasks or running complex business operations.</p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                    <div class="relative pl-16">
                        <dt class="text-base/7 font-semibold text-gray-900">
                            <div class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-indigo-600">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 text-white">
                                    <path d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            Jpg to pdf
                        </dt>
                        <dd class="mt-2 text-base/7 text-gray-600">Convert JPG to PDF instantly, preserving image quality for professional, organized, and easy document sharing.</dd>
                    </div>
                    <div class="relative pl-16">
                        <dt class="text-base/7 font-semibold text-gray-900">
                            <div class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-indigo-600">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 text-white">
                                    <path d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            Document tools
                        </dt>
                        <dd class="mt-2 text-base/7 text-gray-600">Edit, convert, and create with document tools, from Word/PPT to PDF to instant professional invoice generation.</dd>
                    </div>
                    <div class="relative pl-16">
                        <dt class="text-base/7 font-semibold text-gray-900">
                            <div class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-indigo-600">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 text-white">
                                    <path d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            Image tools
                        </dt>
                        <dd class="mt-2 text-base/7 text-gray-600">Easily convert images between JPG, PNG, and WebP formats, preserving quality for fast, reliable, and versatile use.</dd>
                    </div>
                    <div class="relative pl-16">
                        <dt class="text-base/7 font-semibold text-gray-900">
                            <div class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-indigo-600">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 text-white">
                                    <path d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            QR codes
                        </dt>
                        <dd class="mt-2 text-base/7 text-gray-600">Generate custom QR codes for WiFi, contact details, and URLs, making sharing simple, fast, and secure.</dd>
                    </div>
                </dl>
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
<section class="bg-white dark:bg-gray-900">
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl">From the blog</h2>
                <p class="mt-2 text-lg/8 text-gray-600">Learn how to grow your business with our expert advice.</p>
            </div>
            <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($blogs as $blog)
                <article
                 onclick="window.location='{{ route('blogs.show', $blog->slug) }}'"
                 class="flex max-w-xl flex-col items-start justify-between cursor-pointer">
                    @if ($blog->featured_image)
                    <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover rounded-xl">
                    @endif
                    <div class="flex items-center gap-x-4 text-xs">
                        <time datetime="2020-03-16" class="text-gray-500">{{$blog->published_at->format('F j, Y')}}</time>
                        <a href="#" class="capitalize relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">{{pathinfo($blog->featured_image, PATHINFO_FILENAME)}}</a>
                    </div>
                    <div class="group relative grow">
                        <h3 class="mt-3 text-lg/6 font-semibold text-gray-900 group-hover:text-gray-600">
                            <a href="#">
                                <span class="absolute inset-0"></span>
                                {{ $blog->title }}
                            </a>
                        </h3>
                        <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600">{{ Str::limit(strip_tags($blog->excerpt), 100) }}</p>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection