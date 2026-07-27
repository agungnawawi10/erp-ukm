<?php

use App\Exports\PurchaseReportExport;
use App\Exports\SalesReportExport;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::redirect('/', '/admin');

Route::get(
    '/invoice/{salesTransaction}/print',
    [InvoiceController::class, 'print']
)->name('invoice.print');

Route::middleware(['auth'])->get('/admin/sales-reports/export', function () {
    return Excel::download(new SalesReportExport(), 'sales-report.xlsx');
})->name('sales-reports.export');
Route::middleware(['auth'])->get('/admin/purchase-reports/export', function () {
    return Excel::download(new PurchaseReportExport(), 'purchase-report.xlsx');
})->name('purchase-reports.export');
