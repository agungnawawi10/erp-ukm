<?php

namespace App\Filament\Resources\SalesTransactions\Pages;

use App\Filament\Resources\SalesTransactions\SalesTransactionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSalesTransaction extends EditRecord
{
    protected static string $resource = SalesTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
