@extends('layouts.app')

@section('title', 'Adsdigi | Homepage')

@section('content')
<section class="bg-gradient-to-br from-red-500 to-red-700 min-h-screen flex items-center justify-center px-6">
  <div class="max-w-3xl w-full text-center text-white">

    <!-- Title & Subtitle -->
    <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
      {{ $title ?? 'Free JPG to PDF Converter' }}
    </h1>
    <p class="text-red-100 mb-8">
      {{ $subtitle ?? "Pictures and videos make for great content, but don’t forget about documents like reports and records in their usual PDF files, too. Convert JPG to PDF easily with our free online converter." }}
    </p>

    <!-- Dropzone -->
    <div id="dropZoneArea"
         class="border-2 border-dashed border-red-300 rounded-2xl p-10 bg-white/10 hover:bg-white/15 transition
                flex flex-col items-center justify-center">
      <label id="selectFile" for="file-upload" class="cursor-pointer font-semibold flex flex-col">
      <i class="bi bi-cloud-arrow-up text-5xl mb-4"></i>
        Upload your file
      </label>
      <span class="text-red-200 text-sm">or drag & drop it here</span>
    </div>

    <!-- Preview -->
    <div id="imgContainer" class="hidden flex-col items-center mt-6">
      <img id="imgPreview" src="" alt="Preview" class="max-w-sm rounded-xl shadow-lg mb-2 bg-white">
    </div>

    <!-- Submit Form (unchanged functionally) -->
    <form action="{{ url($actionUrl) }}" method="POST" enctype="multipart/form-data"
          class="space-y-6 flex flex-col items-center justify-center pt-6">
      @csrf
      <input type="file" name="file" id="file-upload" class="hidden" required />
      <button id="convert-button"
              class="cursor-pointer inline-flex items-center px-6 py-3 bg-white text-red-700 text-lg font-semibold
                     rounded-lg shadow-lg hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-white"
              type="submit" style="display:none;">
        Convert File Now
      </button>
    </form>

    <!-- Error Handling -->
    @if ($errors->any())
      <div class="mt-6 bg-red-100 text-red-700 border border-red-400 rounded p-4 mb-4 text-left max-w-xl mx-auto">
        <strong class="block font-medium">Error!</strong>
        <ul class="list-disc list-inside mt-2">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

  </div>

  <!-- highlight style for drag state -->
  <style>
    #dropZoneArea.highlight {
      border-color: #ffffff;
      background-color: rgba(255,255,255,0.18);
    }
  </style>
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
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                        if (file) {
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
                                imgPreview.src = '/ilustration_landing_page.png';
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
            });
</script>
@endpush
@endsection