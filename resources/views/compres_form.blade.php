@extends('layouts.app', ['noFooter' => true])

@section('title', 'Compress PDF — Edit')

@section('content')
<section class="min-h-screen bg-gray-50 pb-24">
    {{-- TOP CONFIG (sticky, taruh di bawah navbar tetap) --}}
    <div class="sticky top-14 z-40 bg-white/95 backdrop-blur border-b" style="top:60px">
        <form id="compress-form"
            class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-3 flex-wrap">
            @csrf
            <div class="flex items-center gap-4 flex-wrap">
                <div class="text-sm">
                    <div class="text-gray-500 mb-1">DPI render</div>
                    <input id="dpi" type="number" min="72" max="300" value="90"
                        class="w-28 rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" />
                </div>
                <div class="text-sm">
                    <div class="text-gray-500 mb-1">Quality (JPEG)</div>
                    <input id="quality" type="number" min="10" max="100" value="50"
                        class="w-28 rounded-lg border-gray-300 focus:ring-purple-500 focus:border-purple-500" />
                </div>

            </div>

            <div class="flex items-center gap-3">

                <button type="button" id="rerender"
                    class="text-gray-700 bg-white border py-2 px-5 rounded-lg hover:bg-purple-800 hover:text-white transition-colors">
                    Re-render thumbs
                </button>
                <button type="submit"
                    class="bg-purple-600 text-white px-5 py-2 rounded-lg shadow hover:bg-purple-700">
                    Compress & Download
                </button>
            </div>
        </form>
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-3 flex-wrap">
            <div class="text-sm text-gray-600">
                @php
                $__displayName = $name ?? (isset($previewUrl) ? basename(parse_url($previewUrl, PHP_URL_PATH)) : 'document.pdf');
                @endphp
                <div>File: <span class="font-medium" id="file-name">{{ $__displayName }}</span></div>
            </div>
            <div id="info-pages" class="hidden"></div>
        </div>
    </div>

    {{-- HEADER / breadcrumb --}}
    <div class="max-w-5xl mx-auto px-4">
        <div class="mb-4 mt-6 text-sm text-gray-600">
            <a href="{{ route('pdf.compress.form') }}" class="text-gray-500 hover:text-purple-700 transition-colors">← Upload again</a>
        </div>
    </div>

    {{-- GRID thumbnails (preview) --}}
    <div class="max-w-5xl mx-auto px-4 py-10">
        <span id="render-status" class="text-sm text-gray-500 hidden"></span>
        <span id="compress-status" class="text-sm text-gray-500 hidden"></span>
        <ul id="page-grid" class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10"></ul>
    </div>

    {{-- FAB bottom-right: Replace PDF --}}
    <div class="fixed bottom-6 right-6 z-50">
        <div class="relative group">
            <input id="replace-file" type="file" accept="application/pdf" class="hidden">

            <button id="fab-replace" type="button" aria-describedby="fab-tooltip"
                class="h-14 w-14 rounded-full bg-purple-600 text-white shadow-xl
                   hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-400
                   flex items-center justify-center">
                {{-- repeat icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M7 7h11v3l4-4-4-4v3H6a5 5 0 0 0-5 5v1h2V10a3 3 0 0 1 3-3Zm10 10H6v-3l-4 4 4 4v-3h12a5 5 0 0 0 5-5v-1h-2v1a3 3 0 0 1-3 3Z" />
                </svg>
                <span class="sr-only">Replace PDF</span>
            </button>

            {{-- Tooltip --}}
            <div id="fab-tooltip" role="tooltip"
                class="absolute bottom-full right-0 mb-2
                px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded shadow-lg
                opacity-0 translate-y-1 pointer-events-none
                transition duration-150 ease-out
                group-hover:opacity-100 group-hover:translate-y-0
                group-focus-within:opacity-100 group-focus-within:translate-y-0">
                Replace file PDF
                <span class="absolute -bottom-1 right-4 w-2 h-2 bg-gray-900 rotate-45"></span>
            </div>
        </div>
    </div>
    <div id="fab-status"
        class="fixed bottom-24 right-6 bg-black/70 text-white text-sm px-3 py-1 rounded-md hidden z-50"></div>

    <input type="hidden" id="initial-url" value="{{ $previewUrl }}">
</section>

@endsection

@push('scripts')
<script>
    // Loader helper + fallback (CDN) supaya aman di shared hosting
    function loadScript(src) {
        return new Promise((res, rej) => {
            const s = document.createElement('script');
            s.src = src;
            s.onload = res;
            s.onerror = rej;
            document.head.appendChild(s);
        });
    }
    async function ensurePdfJs() {
        if (!window.pdfjsLib) {
            try {
                await loadScript('/js/pdf.min.js');
            } catch {
                await loadScript('/js/pdf.min.js');
            }
        }
        if (window.pdfjsLib) {
            pdfjsLib.GlobalWorkerOptions.workerSrc = '/js/pdf.worker.min.js';
        }
    }
    async function ensureJsPDF() {
        if (window.jspdf && window.jspdf.jsPDF) return window.jspdf.jsPDF;
        if (window.jsPDF) return window.jsPDF; // v1.x
        try {
            await loadScript('/js/jspdf.umd.min.js');
        } catch {
            await loadScript('/js/jspdf.umd.min.js');
        }
        return (window.jspdf && window.jspdf.jsPDF) ? window.jspdf.jsPDF : window.jsPDF || null;
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        await ensurePdfJs();
        const JsPDF = await ensureJsPDF();
        if (!window.pdfjsLib || !JsPDF) {
            alert('Gagal memuat library PDF di browser.');
            return;
        }

        // Elemen
        const grid = document.getElementById('page-grid');
        const form = document.getElementById('compress-form');
        const replaceFileInp = document.getElementById('replace-file');
        const addStatus = document.getElementById('add-status');
        const rerenderBtn = document.getElementById('rerender');
        const dpiInput = document.getElementById('dpi');
        const qualityInput = document.getElementById('quality');
        const renderStatus = document.getElementById('render-status');
        const compressStatus = document.getElementById('compress-status');
        const infoPages = document.getElementById('info-pages');
        const initialUrl = document.getElementById('initial-url').value;
        const fileNameEl = document.getElementById('file-name');
        const fab = document.getElementById('fab-replace');
        fab.addEventListener('click', () => replaceFileInp.click());
        let source = {
            type: 'url',
            value: initialUrl
        };

        function toast(el, msg, ms = 1500) {
            if (!el) return;
            el.textContent = msg;
            el.classList.remove('hidden');
            clearTimeout(el._t);
            el._t = setTimeout(() => el.classList.add('hidden'), ms);
        }

        function bytesToMB(b) {
            return (b / 1024 / 1024).toFixed(2) + ' MB';
        }

        async function renderThumbs() {
            grid.innerHTML = '';
            try {
                toast(renderStatus, 'Rendering thumbnails...');
                let loadingTask;
                if (source.type === 'url') {
                    loadingTask = pdfjsLib.getDocument({
                        url: source.value,
                        withCredentials: true
                    });
                } else {
                    const buf = await source.value.arrayBuffer();
                    loadingTask = pdfjsLib.getDocument({
                        data: buf
                    });
                }
                const pdf = await loadingTask.promise;
                const total = pdf.numPages;
                infoPages.textContent = `${total} pages`;
                infoPages.classList.remove('hidden');

                const maxThumbs = Math.min(12, total);
                for (let p = 1; p <= maxThumbs; p++) {
                    const li = document.createElement('li');
                    li.className = 'bg-white rounded-2xl shadow border border-gray-200 p-4 select-none';
                    li.innerHTML = `
          <div class="w-full aspect-[3/4] overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center">
            <canvas class="pdf-thumb"></canvas>
          </div>
          <div class="mt-3 text-xs text-gray-700">Page ${p}</div>
        `;
                    grid.appendChild(li);

                    const page = await pdf.getPage(p);
                    const boxW = (li.querySelector('.pdf-thumb').parentElement.clientWidth || 240);
                    const viewport1 = page.getViewport({
                        scale: 1
                    });
                    const scale = boxW / viewport1.width;
                    const v = page.getViewport({
                        scale
                    });
                    const canvas = li.querySelector('canvas.pdf-thumb');
                    canvas.width = Math.floor(v.width);
                    canvas.height = Math.floor(v.height);
                    await page.render({
                        canvasContext: canvas.getContext('2d'),
                        viewport: v
                    }).promise;
                }
                toast(renderStatus, 'Thumbnails ready.');
            } catch (e) {
                console.error(e);
                grid.innerHTML = `<li class="text-gray-500">Preview failed.</li>`;
                toast(renderStatus, 'Failed to render preview.', 2000);
            }
        }

        await renderThumbs();

        // Replace PDF lokal (tanpa upload)
        replaceFileInp.addEventListener('change', () => {
            if (!replaceFileInp.files?.length) return;
            const f = replaceFileInp.files[0];
            if (f.type !== 'application/pdf') {
                alert('File harus PDF');
                replaceFileInp.value = '';
                return;
            }
            source = {
                type: 'file',
                value: f
            };
            fileNameEl.textContent = f.name;
            addStatus.textContent = 'PDF replaced';
            setTimeout(() => addStatus.textContent = '', 1500);
            renderThumbs();
        });

        // Re-render thumbnails (kalau ganti DPI ingin lihat skala)
        rerenderBtn.addEventListener('click', renderThumbs);

        // Compress & Download
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const dpi = Math.max(72, Math.min(300, parseInt(dpiInput.value || '144', 10)));
                const quality = Math.max(10, Math.min(100, parseInt(qualityInput.value || '60', 10))) / 100;

                toast(compressStatus, 'Reading PDF...');
                let pdf;
                if (source.type === 'url') {
                    pdf = await pdfjsLib.getDocument({
                        url: source.value,
                        withCredentials: true
                    }).promise;
                } else {
                    const buf = await source.value.arrayBuffer();
                    pdf = await pdfjsLib.getDocument({
                        data: buf
                    }).promise;
                }

                const total = pdf.numPages;
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                let doc;
                let estOriginal = source.type === 'file' ? source.value.size : 0;

                for (let p = 1; p <= total; p++) {
                    toast(compressStatus, `Compressing page ${p}/${total}...`);
                    const page = await pdf.getPage(p);
                    const scale = dpi / 72;
                    const viewport = page.getViewport({
                        scale
                    });
                    canvas.width = Math.floor(viewport.width);
                    canvas.height = Math.floor(viewport.height);
                    await page.render({
                        canvasContext: ctx,
                        viewport
                    }).promise;

                    const dataUrl = canvas.toDataURL('image/jpeg', quality);
                    const mmW = viewport.width * 25.4 / dpi;
                    const mmH = viewport.height * 25.4 / dpi;
                    const orientation = mmW >= mmH ? 'l' : 'p';

                    if (!doc) {
                        doc = new JsPDF({
                            orientation,
                            unit: 'mm',
                            format: [mmW, mmH]
                        });
                    } else {
                        doc.addPage([mmW, mmH], orientation);
                    }

                    doc.addImage(dataUrl, 'JPEG', 0, 0, mmW, mmH, undefined, 'FAST');
                }

                toast(compressStatus, 'Generating file...');
                const out = doc.output('blob');
                const a = document.createElement('a');
                a.href = URL.createObjectURL(out);
                a.download = 'compressed.pdf';
                document.body.appendChild(a);
                a.click();
                a.remove();

                if (estOriginal > 0) {
                    const saved = Math.max(0, estOriginal - out.size);
                    const pct = ((saved / estOriginal) * 100).toFixed(1);
                    toast(compressStatus, `Done. Saved ~${pct}% (${bytesToMB(estOriginal)} → ${bytesToMB(out.size)})`, 4000);
                } else {
                    toast(compressStatus, 'Done. File downloaded.', 2000);
                }
            } catch (err) {
                console.error(err);
                alert('Failed to compress PDF in the browser.');
            }
        });
    });
</script>
@endpush