<?php

namespace App\Http\Controllers;

use App\Models\SalesTransaction;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function print(SalesTransaction $salesTransaction)
    {
        $pdf = Pdf::loadView(
            'pdf.invoice',
            [
                'transaction' => $salesTransaction->load([
                    'customer',
                    'items.product',
                ]),
            ]
        );

        return $pdf->stream(
            'invoice-' .
                $salesTransaction->invoice_number .
                '.pdf'
        );
    }
}
