@extends('layouts.app')

@section('content')
<section class="bg-white">
    <div class="max-w-screen-md mx-auto px-4 py-12">
        <div class="mb-4 text-sm text-gray-600 mt-6">
            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="text-gray-500 hover:text-purple-600">← Back</a>
        </div>

        <h1 class="text-3xl font-bold mb-6 text-center">Upload your Images to PDF</h1>

        <div class="container mx-auto">
            <form action="{{ route('upload.handle') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Dropzone --}}
                <label for="image-upload" class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-200 hover:bg-gray-100 cursor-pointer transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-purple-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L4 7m3-3l3 3m4 4v8m0 0l-3-3m3 3l3-3" />
                    </svg>
                    <span class="text-gray-500 font-bold">Click to upload or drag & drop JPG files</span>
                    <input id="image-upload" name="images[]" type="file" accept="image/*" multiple required class="hidden">
                </label>

                {{-- Preview Area --}}
                <div id="file-preview" class="text-sm text-gray-600"></div>

                {{-- Submit --}}
                <div class="text-center">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md shadow-md transition">
                         Upload & Continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const uploadInput = document.getElementById('image-upload');
        const previewContainer = document.getElementById('file-preview');

        uploadInput.addEventListener('change', () => {
            const files = Array.from(uploadInput.files);
            if (files.length > 0) {
                previewContainer.innerHTML = files.map(file => `📄 ${file.name}`).join('<br>');
            } else {
                previewContainer.innerHTML = '';
            }
        });
    });
</script>
@endpush
@endsection
