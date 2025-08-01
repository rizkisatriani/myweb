<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
   <style>
    body {
        font-family: sans-serif;
        font-size: 12px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        page-break-inside: auto;
    }
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
        vertical-align: top;
    }
    .text-right {
        text-align: right;
    }
</style>
</head>
<body>
    <h1>{{ $invoice['header'] }} #{{ $invoice['number'] }}</h1>
    <p><strong>Bill To:</strong> {{ $invoice['to'] }}</p>
    <p><strong>Date:</strong> {{ $invoice['date'] }}</p>
    <p><strong>Due Date:</strong> {{ $invoice['due_date'] }}</p>

    <table>
        <thead>
            <tr>
                <th>{{ $invoice['item_header'] }}</th>
                <th>{{ $invoice['quantity_header'] }}</th>
                <th>{{ $invoice['unit_cost_header'] }}</th>
                <th>{{ $invoice['amount_header'] }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice['items'] as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td class="text-right">{{ $item['quantity'] }}</td>
                    <td class="text-right">${{ number_format($item['unit_cost'], 2) }}</td>
                    <td class="text-right">${{ number_format($item['amount'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>{{ $invoice['subtotal_title'] }}:</strong> ${{ number_format($invoice['subtotal'], 2) }}</p>
    <p><strong>{{ $invoice['tax_title'] }}:</strong> {{ $invoice['tax'] }}%</p>
    <p><strong>{{ $invoice['total_title'] }}:</strong> ${{ number_format($invoice['total'], 2) }}</p>

    <p><strong>{{ $invoice['notes_title'] }}:</strong> {{ $invoice['notes'] }}</p>
    <p><strong>{{ $invoice['terms_title'] }}:</strong> {{ $invoice['terms'] }}</p>
</body>
</html>
        <thead>
            <tr>
                <th>{{ $invoice['item_header'] }}</th>
                <th>{{ $invoice['quantity_header'] }}</th>
                <th>{{ $invoice['unit_cost_header'] }}</th>
                <th>{{ $invoice['amount_header'] }}</th>
            </tr>
        </thead>
        <tbody
