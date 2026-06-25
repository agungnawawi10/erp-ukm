<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/invoice/{salesTransaction}/print',
    [InvoiceController::class, 'print']
)->name('invoice.print');
