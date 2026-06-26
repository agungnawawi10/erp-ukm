<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;

class LowStockProductsWidget extends TableWidget
{
    protected static ?string $heading = 'Low Stock Products';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->where('stock', '<=', 10)
                    ->orderBy('stock')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Product'),

                TextColumn::make('stock')
                    ->badge()
                    ->color('danger'),
            ]);
    }
}
