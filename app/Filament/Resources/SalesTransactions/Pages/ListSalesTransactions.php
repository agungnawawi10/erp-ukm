<?php

namespace App\Filament\Resources\SalesTransactions\Pages;

use App\Filament\Resources\SalesTransactions\SalesTransactionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSalesTransactions extends ListRecords
{
    protected static string $resource = SalesTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
