@extends('layouts.app')

@section('title', 'Adsdigi | Homepage')

@section('content')
<section class="bg-white ">
    <div class=" max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="max-w-4xl mx-auto bg-white shadow rounded-lg p-6 flex flex-col lg:flex-row gap-6"> 
            <!-- Left Section - Input and Options -->
            <div class="w-full lg:w-1/2">
                <h2 class="text-2xl font-semibold mb-4">Enter your text or URL</h2>
                <form action="{{ route('qrcode.generate') }}" method="POST">
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
                <div class="p-4 border rounded-lg bg-gray-100 text-center">
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
</section>

@endsection