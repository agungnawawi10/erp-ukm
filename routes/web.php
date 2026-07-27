<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::get(
    '/invoice/{salesTransaction}/print',
    [InvoiceController::class, 'print']
)->name('invoice.print');
