<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;

class InvoiceController extends Controller
{
    public function create()
    {
        return view('invoice_form', [
            'breadCrumb' => 'JPG to PDF Tool',
            'title' =>   __('invoice.title'),
            'subtitle' =>   __('invoice.subtitle'),
            'actionUrl' => 'en/convert-jpg-to-pdf',
        ]);
    }

    public function generate(Request $request)
    {
        $items = $request->input('items');
        $subtotal = 0;

        // Hitung amount per item & subtotal
        foreach ($items as $key => $item) {
            $items[$key]['amount'] = $item['quantity'] * $item['unit_cost'];
            $subtotal += $items[$key]['amount'];
        }

        $taxAmount = $subtotal * ($request->tax / 100);
        $total = $subtotal + $taxAmount;

        $invoice = [
            "header" => "INVOICE",
            "number" => rand(1000, 9999),
            "purchase_order" => $request->purchase_order ?? '-',
            "date" => date('M d, Y', strtotime($request->date)),
            "due_date" => date('M d, Y', strtotime($request->due_date)),
            "payment_terms" => "2",
            "to" => $request->to,
            "items" => $items,
            "subtotal" => $subtotal,
            "tax" => $request->tax,
            "total" => $total,
            "amount_paid" => 0,
            "balance" => $total,
            "notes" => $request->notes,
            "terms" => $request->terms,
            "invoice_number_title" => "#",
            "purchase_order_title" => "PO Number",
            "to_title" => "Bill To",
            "date_title" => "Date",
            "payment_terms_title" => "Payment Terms",
            "due_date_title" => "Due Date",
            "item_header" => "Item",
            "quantity_header" => "Quantity",
            "unit_cost_header" => "Rate",
            "amount_header" => "Amount",
            "subtotal_title" => "Subtotal",
            "tax_title" => "Tax",
            "total_title" => "Total",
            "amount_paid_title" => "Amount Paid",
            "balance_title" => "Balance Due",
            "notes_title" => "Notes",
            "terms_title" => "Terms",
        ];

        // Render Blade to HTML string
        $html = View::make('invoice', ['invoice' => $invoice])->render();
        file_put_contents(storage_path('app/invoice-test.html'), $html);
        try {
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->SetHTMLHeader('<div style="text-align: right; font-size: 10px;">Invoice #' . $invoice['number'] . '</div>');
            $mpdf->SetHTMLFooter('<div style="text-align: center; font-size: 10px;">Page {PAGENO} of {nbpg}</div>');

            // return $mpdf->Output('invoice.pdf', 'I');
            return response($mpdf->Output('', 'S'), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="invoice_' . $invoice['number'] . '.pdf"');
        } catch (\Mpdf\MpdfException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
