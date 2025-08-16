@extends('layouts.app', ['noFooter' => true])

@section('title', 'Merge PDF — Edit')

@section('content')
<section class="min-h-screen bg-gray-50 pb-24">
  {{-- TOP CONFIG (sticky) --}}
  <div class="sticky top-14 z-40 bg-white/95 backdrop-blur border-b">
    <form id="merge-form"
          class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between gap-3 flex-wrap">
      @csrf
      <input type="hidden" name="bucket" value="{{ $bucket }}">
      <div id="order-container"></div>

      <div class="flex items-center gap-4 flex-wrap">
        <span id="order-status" class="text-sm text-gray-500 hidden"></span>
        <span id="merge-status" class="text-sm text-gray-500 hidden"></span>
      </div>

      <div class="flex items-center gap-3">
        <button type="button" id="refresh-order"
                class="text-gray-700 bg-white border py-2 px-5 rounded-lg hover:bg-purple-800 hover:text-white transition-colors">
          Refresh order
        </button>
        <button type="submit"
                class="bg-purple-600 text-white px-5 py-2 rounded-lg shadow hover:bg-purple-700">
          Merge & Download
        </button>
      </div>
    </form>
  </div>

  {{-- HEADER / back link --}}
  <div class="max-w-5xl mx-auto px-4">
    <div class="mb-4 mt-6 text-sm text-gray-600">
      <a href="{{ route('pdf.merge.form') }}" class="text-gray-500 hover:text-purple-700 transition-colors">← Upload again</a>
    </div>
  </div>

  {{-- GRID thumbnails --}}
  <div class="max-w-5xl mx-auto px-4 py-10">
    <ul id="file-grid" class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10">
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
  </div>

  {{-- FAB Add more PDFs (bottom-right) + tooltip --}}
  <div class="fixed bottom-6 right-6 z-50">
    <div class="relative group">
      <input id="more-files" type="file" accept="application/pdf" multiple class="hidden">
      <button id="fab-add" type="button" aria-describedby="fab-tooltip"
              class="h-14 w-14 rounded-full bg-purple-600 text-white shadow-xl
                     hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-400
                     flex items-center justify-center">
        {{-- plus icon --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 5c.552 0 1 .448 1 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H6a1 1 0 110-2h5V6c0-.552.448-1 1-1z"/>
        </svg>
        <span class="sr-only">Add more PDFs</span>
      </button>
      {{-- Tooltip --}}
      <div id="fab-tooltip" role="tooltip"
           class="absolute bottom-full right-0 mb-2
                  px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded shadow-lg
                  opacity-0 translate-y-1 pointer-events-none
                  transition duration-150 ease-out
                  group-hover:opacity-100 group-hover:translate-y-0
                  group-focus-within:opacity-100 group-focus-within:translate-y-0">
        Add more PDFs
        <span class="absolute -bottom-1 right-4 w-2 h-2 bg-gray-900 rotate-45"></span>
      </div>
    </div>
  </div>

  {{-- Status kecil untuk upload tambahan (dipakai oleh JS) --}}
  <div id="add-status" class="fixed bottom-24 right-6 text-sm text-gray-700"></div>
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
  const grid           = document.getElementById('file-grid');
  const form           = document.getElementById('merge-form');
  const orderContainer = document.getElementById('order-container');
  const moreFiles      = document.getElementById('more-files');
  const fabAdd         = document.getElementById('fab-add');      // <— NEW trigger
  const addStatus      = document.getElementById('add-status');
  const refreshBtn     = document.getElementById('refresh-order');
  const orderStatus    = document.getElementById('order-status');
  const mergeStatus    = document.getElementById('merge-status');

  // FAB opens file picker
  fabAdd.addEventListener('click', () => moreFiles.click());

  // Drag & drop + auto update
  Sortable.create(grid, {
    animation: 150,
    onEnd: () => buildOrderInputs(true)
  });

  function toast(el, msg, ms = 1500) {
    if (!el) return;
    el.textContent = msg;
    el.classList.remove('hidden');
    clearTimeout(el._t);
    el._t = setTimeout(() => el.textContent = '', ms); // empty string hides the floating label naturally
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
    toast(addStatus, 'Uploading...');

    const fd = new FormData();
    fd.append('bucket', '{{ $bucket }}');
    Array.from(moreFiles.files).forEach(f => fd.append('files[]', f));

    try {
      const res  = await fetch("{{ route('pdf.merge.upload_more') }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}',
    'Accept': 'application/json' },
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
      toast(addStatus, 'Added!');
    } catch (err) {
      console.error(err);
      toast(addStatus, 'Failed to add files.');
      alert('Failed to add PDFs.',err);
    } finally {
      moreFiles.value = '';
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

  // Mobile touch hint for tooltip
  const fabTooltip = document.getElementById('fab-tooltip');
  fabAdd.addEventListener('touchstart', () => {
    fabTooltip?.classList.add('opacity-100','translate-y-0');
    clearTimeout(fabTooltip._t);
    fabTooltip._t = setTimeout(()=>fabTooltip?.classList.remove('opacity-100','translate-y-0'), 1200);
  }, { passive: true });
});
</script>
@endpush
