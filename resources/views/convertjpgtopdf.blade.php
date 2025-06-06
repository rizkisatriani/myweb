@extends('layouts.app')

@section('title', 'Adsdigi | Homepage')

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="container mx-auto">
            <!-- Breadcrumb -->
            <div class="text-sm text-gray-600 mb-4">
                <a href="#" class="text-gray-500 hover:text-purple-600">Home</a> &gt;
                <a href="#" class="text-gray-500 hover:text-purple-600">Photo Editor</a> &gt;
                <span class="text-purple-800 font-semibold">{{$breadCrumb}}</span>
            </div>

            <!-- Main Section -->
            <div class="relative bg-purple-100 rounded-lg p-4">
                <!-- Background Decorations -->
                <div class="absolute top-0 left-0 w-16 h-16 bg-purple-200 rounded-full transform -translate-x-4 -translate-y-4"></div>
                <div class="absolute bottom-0 right-0 w-20 h-20 bg-purple-300 rounded-full transform translate-x-4 translate-y-4"></div>

                <!-- Content -->
                <style>
                    /* Dropzone styling */
                    #dropZoneArea {
                        border: 2px dashed #ccc;
                        padding: 20px;
                        text-align: center;
                        border-radius: 10px;
                        transition: all 0.3s ease-in-out;
                        font-size: 16px;
                        color: #666;
                        background-color: #f9f9f9;
                        position: relative;
                        margin-top: 30px;
                    }

                    /* Drop indicator when dragging over */
                    #dropZoneArea.highlight {
                        border-color: #4a90e2;
                        background-color: #e3f2fd;
                        color: #4a90e2;
                        animation: pulse 1s infinite;
                    }

                    /* Dashed border animation */
                    @keyframes pulse {
                        0% {
                            border-color: #4a90e2;
                        }

                        50% {
                            border-color: #72b8ff;
                        }

                        100% {
                            border-color: #4a90e2;
                        }
                    }

                    /* Image preview styling */
                    #imgContainer {
                        display: none;
                        text-align: center;
                        margin-top: 20px;
                    }

                    #imgPreview {
                        max-width: 300px;
                        border-radius: 10px;
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                    }
                </style>

                <div class="relative z-10 bg-white rounded-xl p-6">
                    <h1 class="text-3xl font-extrabold text-gray-800 text-center mb-4">{{ $title }}</h1>
                    <p class="text-gray-500 text-center mb-6">
                        {{ $subtitle }}
                    </p>

                    <!-- Upload Button -->
                    <div class="text-center" id="selectFile">
                        <label for="file-upload"
                            class="cursor-pointer inline-flex items-center px-5 py-8 bg-purple-600 text-white text-lg font-semibold rounded-lg shadow-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                <path d="M12 2v12M12 2L8 6M12 2l4 4M4 16h16"></path>
                            </svg>
                            {{ __('convertjpgtopdf.upload_image') }}
                        </label>
                        <!-- <input id="file-upload" type="file" accept="image/*" class="hidden" onchange="handleFileSelect(event)" /> -->
                    </div>

                    <!-- Dropzone Area -->
                    <div id="dropZoneArea">
                        Drag & Drop File Here
                    </div>

                    <!-- Image Preview -->
                    <div class="flex justify-center mt-4" id="imgContainer">
                        <img src="" alt="Preview" id="imgPreview">
                    </div>

                    <!-- Convert Button (hidden initially) -->
                    <form action="{{ url($actionUrl) }}" method="POST" enctype="multipart/form-data" class="space-y-6 flex justify-center pt-6">
                        @csrf
                        <input type="file" name="image" id="file-upload" class="hidden" required />
                        <button id="convert-button"
                            class="cursor-pointer inline-flex items-center px-5 py-8 bg-purple-600 text-white text-lg font-semibold rounded-lg shadow-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
                            type="submit" style="display:none;">
                            Convert File Now
                        </button>
                    </form>

                    <!-- Error Handling -->
                    @if ($errors->any())
                    <div class="bg-red-100 text-red-700 border border-red-400 rounded p-4 mb-4">
                        <strong class="block font-medium">Error!</strong>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                <script>
                    const fileInput = document.getElementById("file-upload");
                    const dropZone = document.getElementById("dropZoneArea");
                    const imgPreview = document.getElementById("imgPreview");
                    const imgContainer = document.getElementById("imgContainer");
                    const convertButton = document.getElementById("convert-button");
                    // const selectedFileInput = document.getElementById("selected-file");
                    // const fileInput = event.target;
                    // const convertButton = document.getElementById('convert-button');
                    const selectedFileInput = document.getElementById('file-upload');
                    const selectFile = document.getElementById('selectFile');
                    const textDrop = document.getElementById('dropZoneArea');
                    // const imgPreview = document.getElementById('imgPreview');
                    // const imgContainer = document.getElementById('imgContainer');

                    function handleFile(file) {
                        if (file && file.type.startsWith("image/")) {
                            // convertButton.style.display = 'inline-flex';
                            selectedFileInput.files = fileInput.files;
                            selectFile.style.display = 'none'
                            textDrop.style.display = 'none'
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                // imgPreview.src = e.target.result;
                                // imgContainer.style.display = "block";
                                convertButton.style.display = "inline-flex";

                                imgContainer.style.display = 'flex'
                                imgPreview.src = e.target.result;
                            };
                            reader.readAsDataURL(file);

                            // Set file for form submission
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            fileInput.files = dataTransfer.files;
                            selectedFileInput.files = dataTransfer.files;
                        } else {
                            convertButton.style.display = 'none';
                            imgContainer.style.display = 'none'
                            selectFile.style.display = 'inline-flex'
                            textDrop.style.display = 'inline-flex'
                        }
                    }

                    function handleFileSelect(event) {
                        const file = event.target.files[0];
                        handleFile(file);
                    }

                    // Drag & Drop Functionality
                    // function handleFileSelect(event) {

                    //     if (fileInput.files.length > 0) {
                    //         // Show the Convert button

                    //         const file = event.target.files[0];
                    //         const reader = new FileReader();
                    //         reader.onload = function(e) {
                    //         };
                    //         reader.readAsDataURL(file);
                    //     } else {
                    //         convertButton.style.display = 'none';
                    //         imgContainer.style.display = 'none'
                    //         selectFile.style.display = 'inline-flex'
                    //         textDrop.style.display = 'inline-flex'
                    //     }
                    // }
                    ["dragenter", "dragover"].forEach(eventName => {
                        dropZone.addEventListener(eventName, (e) => {
                            e.preventDefault();
                            dropZone.classList.add("highlight");
                        });
                    });

                    ["dragleave", "drop"].forEach(eventName => {
                        dropZone.addEventListener(eventName, (e) => {
                            e.preventDefault();
                            dropZone.classList.remove("highlight");
                        });
                    });

                    dropZone.addEventListener("drop", function(event) {
                        event.preventDefault();
                        const file = event.dataTransfer.files[0];
                        handleFile(file);
                    });

                    fileInput.addEventListener("change", handleFileSelect);
                </script>

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
<section id="image-conversion" class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
    <h1 class="text-3xl font-semibold text-center mb-4">Fast and Easy Image File Conversion Service</h1>
    <p class="text-lg text-gray-700 mb-6">
        Need to convert your image files to a different format? Whether it's for optimizing file size, improving quality, or simply changing the file type for easier sharing, our image file conversion service is here to help. At <strong>Service Name</strong>, you can easily convert your images between various formats quickly, with no extra software or complicated steps required.
    </p>

    <h2 class="text-2xl font-medium text-purple-700 mb-4">Why Convert Image Files?</h2>
    <p class="text-lg text-gray-700 mb-6">
        Image file conversion allows you to switch between formats for different purposes. Whether you want to make the file size smaller for faster loading or improve the image quality for printing, our service offers a simple solution. You can also combine images into one document or convert them into a format that's better suited for web or app use.
    </p>

    <h2 class="text-2xl font-medium text-purple-700 mb-4">Benefits of Using Our Image Conversion Service</h2>
    <ul class="list-disc list-inside text-lg text-gray-700 mb-6">
        <li>Quick and efficient conversion process, no software installation required.</li>
        <li>Supports a variety of image formats, making it flexible for all your needs.</li>
        <li>High-quality output with preserved image integrity after conversion.</li>
        <li>Free and easy to use—convert your images in just a few clicks.</li>
    </ul>

    <h2 class="text-2xl font-medium text-purple-700 mb-4">How It Works</h2>
    <p class="text-lg text-gray-700 mb-6">
        Our service is simple and user-friendly. Just upload your image, choose the desired output format, and let us handle the rest. The conversion process is fast, and you’ll receive the converted image in seconds. Whether you're converting for professional or personal use, we make it easier than ever to get the right format for your needs.
    </p>

    <h2 class="text-2xl font-medium text-purple-700 mb-4">Get Started with Image Conversion</h2>
    <p class="text-lg text-gray-700 mb-6">
        Don’t let file format issues slow you down. Start converting your images today with our fast and easy image conversion tool. Click the button below to begin!
    </p>
</section>
<script>
    // Function to handle file selection


    // Optional: If you need to handle form submission dynamically with AJAX, you can use the following code.
    // document.getElementById('convert-form').addEventListener('submit', function(event) {
    //     event.preventDefault();
    //     // Handle AJAX submission here if needed
    //     // Example: send the form data via fetch or XMLHttpRequest
    // });
</script>

@endsection