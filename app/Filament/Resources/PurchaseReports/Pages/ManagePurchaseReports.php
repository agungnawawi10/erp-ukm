<?php

namespace App\Filament\Resources\PurchaseReports\Pages;

use App\Filament\Resources\PurchaseReports\PurchaseReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePurchaseReports extends ManageRecords
{
    protected static string $resource = PurchaseReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
