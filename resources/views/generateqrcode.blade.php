@extends('layouts.app')

@section('title', 'Adsdigi | Homepage')

@section('content')
<section class="bg-white ">
    <div class=" max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="container mx-auto">
            <!-- Breadcrumb -->
            <div class="text-sm text-gray-600 mb-4">
                <a href="#" class="text-gray-500 hover:text-purple-600">Home</a> &gt;
                <a href="#" class="text-gray-500 hover:text-purple-600">Photo Editor</a> &gt;
                <span class="text-purple-800 font-semibold">{{$breadCrumb}}</span>
            </div>

            <div class="flex space-x-2 p-2"> 
                <a href="{{ route('qrcode.generate', ['locale' => app()->getLocale()]) }}" class="px-4 py-2 text-black rounded-lg bg-gray-900 text-white">URL</a>
                <a href="{{ route('qrcode.generate_contact', ['locale' => app()->getLocale()]) }}" class="px-4 py-2 bg-gray-200 text-black rounded-lg">Contact/VCard</a>
                <a href="{{ route('qrcode.generate_wifi', ['locale' => app()->getLocale()]) }}" class="px-4 py-2 bg-gray-200 text-black rounded-lg">WIFI</a>
            </div>
            <!-- Main Section -->
            <div class="relative bg-gray-100 rounded-lg p-4">
                <!-- Background Decorations -->
                <div class="absolute top-0 left-0 w-16 h-16 bg-red-100 rounded-full transform -translate-x-4 -translate-y-4"></div>
                <div class="absolute bottom-0 right-0 w-20 h-20 bg-purple-300 rounded-full transform translate-x-4 translate-y-4"></div>
                <div class="relative max-w-4xl mx-auto bg-white shadow rounded-lg p-6 flex flex-col lg:flex-col gap-6">
                <h1 class="text-3xl font-bold">URL QR Code Generator</h1>
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- Left Section - Input and Options -->
                        <div class="w-full lg:w-1/2">
                            <h2 class="font-semibold mb-4">Enter your text or URL</h2>
                            <form action="{{ route('qrcode.generate', ['locale' => app()->getLocale()]) }}" method="POST">
                                @csrf
                                <input
                                    type="text"
                                    name="text"
                                    placeholder="Enter your text or URL"
                                    class="w-full p-2 border rounded-lg mb-4"
                                    value="{{ old('text',isset($text)?$text:'') }}"
                                    required>
                                <!-- <div class="flex items-center gap-2 mb-4">
                        <input type="checkbox" id="frame" name="frame" class="w-4 h-4">
                        <label for="frame" class="text-sm pl-3">  Include frame</label>
                    </div> -->
                                <button type="submit" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 sm:mr-2 lg:mr-0 dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800">Generate QR Code</button>
                            </form>
                        </div>

                        <!-- Right Section - QR Code Display -->
                        <div class="w-full lg:w-1/2 shadow flex justify-center items-center">
                            @if($qrCode)
                            <div class="p-4 border rounded-lg bg-gray-100 text-center flex flex-col items-center">
                                {!! $qrCode !!}
                                <div class="mt-4 flex gap-2">
                                    <a href="{{ $qrCodeDownloadUrl }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Download JPG</a>
                                    <a href="{{ $qrCodePrintdUrl }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Print SVG/EPS</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
<section class="bg-white dark:bg-gray-900">
    <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-24 lg:px-6">
        <div class="max-w-screen-md mx-auto mb-8 text-center lg:mb-12">
            <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Boost Efficiency with Our Powerful Features! 🚀</h2>
            <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
            Discover the best solutions tailored to your needs with cutting-edge features designed to enhance productivity, security, 
            and convenience. Experience faster, smarter, and more efficient performance—all in one place!</p>
        </div>
        <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
            <!-- Pricing Card -->
            <div class="flex flex-col max-w-lg p-6 mx-auto text-center text-gray-900 bg-white border border-gray-100 rounded-lg shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                <h3 class="mb-4 text-2xl font-semibold">Image Convert</h3>
                <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">Fast, easy, and high-quality conversions in just one click. Try it now!</p>
                <div class="flex items-baseline justify-center my-8">
                    <img src="{{ asset('images/2.png') }}" alt="Image Convert">
                </div>
                <!-- List -->
                 <div> 
                 <ul role="list" class="mb-8 space-y-4 text-left">
                    <li class="flex items-center space-x-3">
                        <!-- Icon -->
                        <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span><a href="/convert-png-to-jpg">PNG to JPG Tool</a></span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <!-- Icon -->
                        <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span><a href="/convert-jpg-to-png">JPG to PNG Tool</a></span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <!-- Icon -->
                        <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span><a href="/convert-jpg-to-pdf">JPG to PDF Tool</a></span></span>
                    </li> 
                </ul>       
                <!-- <a href="#" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-purple-900">Get started</a> -->
                 </div>
            </div>
            <!-- Pricing Card -->
            <div class="flex flex-col max-w-lg p-6 mx-auto text-center text-gray-900 bg-white border border-gray-100 rounded-lg shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                <h3 class="mb-4 text-2xl font-semibold">Document Convert</h3>
                <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">Fast, easy, and high-quality document conversion in one click. Try it now!</p>
                <div class="flex items-baseline justify-center my-8">
                <img src="{{ asset('images/1.png') }}" alt="Document Convert">
                </div>
                <!-- List -->
                <ul role="list" class="mb-8 space-y-4 text-left">
                <li class="flex items-center space-x-3">
                        <!-- Icon -->
                        <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span><a href="/convert-word-to-pdf">WORD to PDF Tool</a></span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <!-- Icon -->
                        <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span><a href="/convert-ppt-to-pdf">PPT/PPTX to PDF Tool</a></span>
                    </li> 
                </ul>
                <!-- <a href="#" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-purple-900">Get started</a> -->
            </div>
            <!-- Pricing Card -->
            <div class="flex flex-col max-w-lg p-6 mx-auto text-center text-gray-900 bg-white border border-gray-100 rounded-lg shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                <h3 class="mb-4 text-2xl font-semibold">Enterprise</h3>
                <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">Quick, accurate, and reliable speed test in just one click. Check your connection!</p>
                <div class="flex items-baseline justify-center my-8">
                <img src="{{ asset('images/3.png') }}" alt="Speed Test Internet">
                </div>
                <!-- List -->
                <ul role="list" class="mb-8 space-y-4 text-left">
                    <li class="flex items-center space-x-3">
                        <!-- Icon -->
                        <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span><a href="/speed-test-internet">Speed Test</a></span>
                    </li> 
                </ul>
                <!-- <a href="#" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-purple-900">Get started</a> -->
            </div>
        </div>
    </div>
</section>
@endsection