@extends('layouts.app')

@section('title', 'Create Invoice')

@section('content')
<section class="bg-white">
    <div class="max-w-screen-md mx-auto px-4 py-12">
        <div class="mb-4 text-sm text-gray-600 mt-6">
            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="text-gray-500 hover:text-purple-600">← Back</a>
        </div>

        <h1 class="text-3xl font-bold mb-6">Create Invoice</h1>

        <form action="{{ route('invoice.generate', ['locale' => app()->getLocale()]) }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-1">Bill To</label>
                    <input type="text" name="to" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">PO Number</label>
                    <input type="text" name="purchase_order" class="w-full border px-3 py-2 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Invoice Date</label>
                    <input type="date" name="date" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Due Date</label>
                    <input type="date" name="due_date" class="w-full border px-3 py-2 rounded" required>
                </div>
            </div>

            <hr class="my-6">

            <h2 class="text-xl font-semibold mb-2">Invoice Items</h2>
            <div id="items-container" class="space-y-4 mb-6">
                <div class="grid grid-cols-4 gap-4 item-row">
                    <input type="text" name="items[0][name]" placeholder="Item name" class="col-span-2 border px-3 py-2 rounded" required>
                    <input type="number" name="items[0][quantity]" placeholder="Qty" class="border px-3 py-2 rounded" required>
                    <input type="number" name="items[0][unit_cost]" step="0.01" placeholder="Rate" class="border px-3 py-2 rounded" required>
                </div>
            </div>
            <button type="button" onclick="addItem()" class="text-sm text-blue-600 hover:underline mb-6">+ Add another item</button>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium mb-1">Tax (%)</label>
                    <input type="number" name="tax" value="0" class="w-full border px-3 py-2 rounded" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Notes</label>
                <textarea name="notes" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Terms</label>
                <textarea name="terms" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
            </div>

            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                Generate PDF
            </button>
        </form>
    </div>
</section>

<script>
    let itemIndex = 1;
    function addItem() {
        const container = document.getElementById('items-container');
        const row = document.createElement('div');
        row.classList.add('grid', 'grid-cols-4', 'gap-4', 'item-row', 'mt-2');
        row.innerHTML = `
            <input type="text" name="items[${itemIndex}][name]" placeholder="Item name" class="col-span-2 border px-3 py-2 rounded" required>
            <input type="number" name="items[${itemIndex}][quantity]" placeholder="Qty" class="border px-3 py-2 rounded" required>
            <input type="number" name="items[${itemIndex}][unit_cost]" step="0.01" placeholder="Rate" class="border px-3 py-2 rounded" required>
        `;
        container.appendChild(row);
        itemIndex++;
    }
</script>
@endsection
