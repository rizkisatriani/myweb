@extends('layouts.app', ['noFooter' => true])

@section('title', 'Merge PDF — Edit')

@section('content')
<section class="min-h-screen bg-gray-50 py-10 relative">
    <div class="max-w-5xl mx-auto px-4">
        <div class="mb-4 text-sm text-gray-600">
            <a href="{{ route('pdf.merge.form') }}" class="text-gray-500 hover:text-white transition-colors">← Upload again</a>
        </div>

        {{-- Add more PDFs toolbar --}}
        <div class="flex items-center flex-col absolute right-48">
            <input id="more-files" type="file" accept="application/pdf" multiple class="hidden">
            <label for="more-files"
                class="bg-purple-600 text-white px-5 py-2 hover:bg-purple-700 transition-colors cursor-pointer rounded-full w-10 flex justify-center shadow-xl">
                <i class="bi bi-file-earmark-plus"></i>
            </label>
            <span>Add more PDFs</span>
            <span id="add-status" class="text-sm text-gray-500"></span>
        </div>

        {{-- GRID thumbnails --}}
        <ul id="file-grid" class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-24">
            @foreach ($files as $it)
            <li class="bg-white rounded-2xl shadow border border-gray-200 p-4 cursor-move select-none"
                data-path="{{ $it['path'] }}" data-preview="{{ $it['previewUrl'] }}">
                <div class="w-full thumb-box aspect-[3/4] overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center">
                    <canvas class="pdf-thumb"></canvas>
                </div>
                <div class="mt-3 text-xs text-gray-700 truncate" title="{{ $it['name'] }}">
                    {{ $it['name'] }}
                </div>
                <button type="button" class="mt-2 text-red-600 text-sm hover:underline hover:text-white transition-colors remove-btn">
                    Remove
                </button>
            </li>
            @endforeach
        </ul>

        {{-- Sticky footer actions --}}
        <form id="merge-form" action="#" method="POST"
            class="flex items-center justify-between w-full bg-white fixed left-0 bottom-0 p-4 md:p-6 border-t border-gray-200">
            @csrf
            <input type="hidden" name="bucket" value="{{ $bucket }}">
            <div id="order-container"></div>

            <div class="flex items-center gap-3">
                <span id="order-status" class="text-sm text-gray-500 hidden"></span>
                <span id="merge-status" class="text-sm text-gray-500 hidden"></span>
                <button type="button" id="refresh-order"
                    class="text-gray-700 bg-white border py-2 px-5 rounded-lg hover:bg-purple-800 hover:text-white transition-colors">
                    Refresh order
                </button>
                <button type="submit" class="bg-purple-600 text-white px-5 py-2 rounded-lg shadow hover:bg-purple-700">
                    Merge & Download
                </button>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
{{-- SortableJS --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js" crossorigin="anonymous"></script>

{{-- PDF.js (thumbnails) --}}
<script src="/js/pdf.min.js"></script>
<script> pdfjsLib.GlobalWorkerOptions.workerSrc = "/js/pdf.worker.min.js"; </script>

{{-- pdf-lib (client-side merge) --}}
<script src="https://cdn.jsdelivr.net/npm/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const grid          = document.getElementById('file-grid');
    const form          = document.getElementById('merge-form');
    const orderContainer= document.getElementById('order-container');
    const moreFiles     = document.getElementById('more-files');
    const addStatus     = document.getElementById('add-status');
    const refreshBtn    = document.getElementById('refresh-order');
    const orderStatus   = document.getElementById('order-status');
    const mergeStatus   = document.getElementById('merge-status');

    // Drag & drop + auto update
    Sortable.create(grid, {
        animation: 150,
        onEnd: () => buildOrderInputs(true)
    });

    // Helpers
    function toast(el, msg, ms = 1500) {
        if (!el) return;
        el.textContent = msg;
        el.classList.remove('hidden');
        clearTimeout(el._t);
        el._t = setTimeout(() => el.classList.add('hidden'), ms);
    }

    async function renderThumb(liEl) {
        const url    = liEl.getAttribute('data-preview');
        const canvas = liEl.querySelector('canvas.pdf-thumb');
        const box    = liEl.querySelector('.thumb-box');
        try {
            const pdf = await pdfjsLib.getDocument({ url }).promise;
            const page = await pdf.getPage(1);
            const viewport = page.getViewport({ scale: 1 });

            const boxWidth = box.clientWidth || 240;
            const scale    = boxWidth / viewport.width;
            const v        = page.getViewport({ scale });

            canvas.width  = v.width;
            canvas.height = v.height;
            await page.render({ canvasContext: canvas.getContext('2d'), viewport: v }).promise;
        } catch (e) {
            console.error(e);
            canvas.replaceWith(Object.assign(document.createElement('div'), {
                className: 'text-gray-400 text-sm', innerText: 'Preview failed'
            }));
        }
    }

    function liTemplate(item) {
        const li = document.createElement('li');
        li.className = 'bg-white rounded-2xl shadow border border-gray-200 p-4 cursor-move select-none';
        li.setAttribute('data-path', item.path);
        li.setAttribute('data-preview', item.previewUrl);
        li.innerHTML = `
            <div class="w-full thumb-box aspect-[3/4] overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center">
                <canvas class="pdf-thumb"></canvas>
            </div>
            <div class="mt-3 text-xs text-gray-700 truncate" title="${item.name}">${item.name}</div>
            <button type="button" class="mt-2 text-red-600 text-sm hover:underline hover:text-white transition-colors remove-btn">Remove</button>
        `;
        return li;
    }

    async function renderAllExisting() {
        const items = grid.querySelectorAll('li[data-preview]');
        for (const li of items) await renderThumb(li);
    }

    // Initial thumbnails + order
    (async () => { await renderAllExisting(); buildOrderInputs(false); })();

    // Add more (AJAX)
    moreFiles.addEventListener('change', async () => {
        if (!moreFiles.files?.length) return;
        addStatus.textContent = 'Uploading...';

        const fd = new FormData();
        fd.append('bucket', '{{ $bucket }}');
        Array.from(moreFiles.files).forEach(f => fd.append('files[]', f));

        try {
            const res  = await fetch("{{ route('pdf.merge.upload_more') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: fd
            });
            if (!res.ok) throw new Error('Upload failed');
            const json = await res.json();
            if (!json.ok) throw new Error('Server rejected files');

            for (const it of json.items) {
                const li = liTemplate(it);
                grid.appendChild(li);
                await renderThumb(li);
            }
            buildOrderInputs(true);
            addStatus.textContent = 'Added!';
        } catch (err) {
            console.error(err);
            addStatus.textContent = 'Failed to add files.';
            alert('Failed to add PDFs.');
        } finally {
            moreFiles.value = '';
            setTimeout(() => addStatus.textContent = '', 1500);
        }
    });

    // Remove item
    grid.addEventListener('click', async (e) => {
        if (!e.target.classList.contains('remove-btn')) return;
        const li     = e.target.closest('li[data-path]');
        const path   = li.getAttribute('data-path');
        const bucket = document.querySelector('input[name="bucket"]').value;

        try {
            const res  = await fetch("{{ route('pdf.merge.remove') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ bucket, path })
            });
            const json = await res.json();
            if (json.ok) { li.remove(); buildOrderInputs(true); }
            else alert(json.message || 'Failed to delete file.');
        } catch (_) { alert('Failed to delete file.'); }
    });

    // Build order + order badges
    function buildOrderInputs(showToast = false) {
        orderContainer.innerHTML = '';
        const cards = grid.querySelectorAll('li[data-path]');
        cards.forEach((el, idx) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'file_order[]';
            input.value = el.getAttribute('data-path');
            orderContainer.appendChild(input);

            let badge = el.querySelector('.order-badge');
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'order-badge absolute top-2 left-2 z-10 text-xs font-semibold bg-purple-600 text-white rounded-full w-6 h-6 flex items-center justify-center shadow';
                el.classList.add('relative');
                (el.querySelector('.thumb-box') || el).appendChild(badge);
            }
            badge.textContent = String(idx + 1);
        });
        if (showToast) toast(orderStatus, `Order captured (${cards.length} file${cards.length>1?'s':''}).`);
        return cards.length;
    }

    refreshBtn?.addEventListener('click', () => buildOrderInputs(true));

    // CLIENT-SIDE MERGE (pdf-lib)
    form.addEventListener('submit', async (e) => {
        e.preventDefault(); // no server post
        const cards = grid.querySelectorAll('li[data-preview]');
        if (!cards.length) return alert('No files to merge.');

        try {
            toast(mergeStatus, 'Merging in browser...');
            const { PDFDocument } = PDFLib;
            const merged = await PDFDocument.create();

            for (const li of cards) {
                const url   = li.getAttribute('data-preview');
                const bytes = await fetch(url, { credentials: 'same-origin' }).then(r => r.arrayBuffer());
                const src   = await PDFDocument.load(bytes);
                const pages = await merged.copyPages(src, src.getPageIndices());
                pages.forEach(p => merged.addPage(p));
            }

            const out  = await merged.save();
            const blob = new Blob([out], { type: 'application/pdf' });

            // Download to user
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = `merged-${new Date().toISOString().replace(/[:.]/g,'-')}.pdf`;
            document.body.appendChild(a); a.click(); a.remove();

            toast(mergeStatus, 'Merged & downloaded.');
        } catch (err) {
            console.error(err);
            alert('Failed to merge PDFs in the browser.');
        }
    });
});
</script>
@endpush
