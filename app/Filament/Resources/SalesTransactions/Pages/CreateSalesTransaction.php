<?php

namespace App\Filament\Resources\SalesTransactions\Pages;

use App\Filament\Resources\SalesTransactions\SalesTransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSalesTransaction extends CreateRecord
{
    protected static string $resource = SalesTransactionResource::class;
}
