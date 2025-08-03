@extends('layouts.app')

@section('title', 'Convert Images to PDF')

@section('content')
<section class="bg-white">
    <div class="max-w-screen-md mx-auto px-4 py-12">
        <div class="mb-4 text-sm text-gray-600 mt-6">
            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="text-gray-500 hover:text-purple-600">← Back</a>
        </div>

        <h1 class="text-3xl font-bold mb-6">Convert Images to PDF</h1>

        <form action="{{ route('convert.pdf') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Existing Image List --}}
                <div id="image-list" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    @foreach ($images as $image)
                    <div class="relative draggable bg-white shadow-md border border-gray-300 overflow-hidden p-4 aspect-[3/4] aspect-wrapper">
                        <img src="{{ asset('storage/' . $image) }}" class="object-contain w-full h-full">
                        <input type="hidden" name="images[]" value="{{ $image }}">
                    </div>
                    @endforeach
                </div>

            {{-- Upload New Images --}}
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Add More Images</label>
                <input type="file" id="image-upload" accept="image/*" multiple class="border px-3 py-2 rounded w-full">
            </div>

            {{-- PDF Options --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-1">Orientation</label>
                    <select name="orientation" class="w-full border px-3 py-2 rounded" id="orientation-select">
                        <option value="portrait">Portrait</option>
                        <option value="landscape">Landscape</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Paper Size</label>
                    <select name="paper" class="w-full border px-3 py-2 rounded">
                        <option value="a4">A4</option>
                        <option value="letter">Letter</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Margin</label>
                    <select  id="margin-select" name="margin" class="w-full border px-3 py-2 rounded">
                        <option value="none">No Margin</option>
                        <option value="small">Small</option>
                        <option value="large">Large</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                Convert to PDF
            </button>
        </form>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () { 
        const imageList = document.getElementById('image-list');
        const uploadInput = document.getElementById('image-upload');
        const orientationSelect = document.getElementById('orientation-select');
        const marginSelect = document.getElementById('margin-select');

        if (!uploadInput || !imageList) {
            console.warn('Element not found: image-upload or image-list');
            return;
        }

        // Inisialisasi drag & drop
        new Sortable(imageList, {
            animation: 150,
            onEnd: () => {
                const reordered = Array.from(imageList.children);
                imageList.innerHTML = '';
                reordered.forEach(el => imageList.appendChild(el));
            }
        });

        // Tampilkan preview gambar baru
        uploadInput.addEventListener('change', function () { 
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('relative', 'draggable');
                    wrapper.dataset.path = file.name + Math.random().toString(36).substr(2, 5);

                    wrapper.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-auto border rounded shadow-sm">
                        <input type="hidden" name="new_images_base64[]" value="${e.target.result}">
                    `;
                    imageList.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });

            this.value = '';
        });

         orientationSelect.addEventListener('change', function () {
            const wrappers = document.querySelectorAll('.aspect-wrapper');

            wrappers.forEach(wrapper => {
                wrapper.classList.remove('aspect-[3/4]', 'aspect-[4/3]');
                if (this.value === 'portrait') {
                    wrapper.classList.add('aspect-[3/4]');
                } else {
                    wrapper.classList.add('aspect-[4/3]');
                }
            });
        }); 

        marginSelect.addEventListener('change', function () { 
            const cards = document.querySelectorAll('.aspect-wrapper');

            cards.forEach(card => {
                card.classList.remove('p-0', 'p-2', 'p-4');

                switch (this.value) {
                    case 'none':
                        card.classList.add('p-0');
                        break;
                    case 'small':
                        card.classList.add('p-2');
                        break;
                    case 'large':
                        card.classList.add('p-4');
                        break;
                }
            });
        });
    }); 
</script>
@endpush
@endsection