<?php

namespace App\Filament\Resources\StockMovements\Pages;

use App\Models\Product;
use App\Filament\Resources\StockMovements\StockMovementResource;
use App\Services\InventoryService;
// use App\Services\InventoryService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateStockMovement extends CreateRecord
{
    protected static string $resource = StockMovementResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $product = Product::findOrFail($data['product_id']);

        $inventory = app(InventoryService::class);

        if ($data['type'] === 'IN') {
            return $inventory->stockIn(
                $product,
                $data['quantity'],
                $data['notes'] ?? null
            );
        }

        if ($data['type'] === 'OUT') {
            return $inventory->stockOut(
                $product,
                $data['quantity'],
                $data['notes'] ?? null
            );
        }

        return $inventory->adjustment(
            $product,
            $data['quantity'],
            $data['notes'] ?? null
        );
    }
}
