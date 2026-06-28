<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget;

class LowStockProductsWidget extends TableWidget
{
    protected int|string|array $columnSpan = 2;
    // protected static ?int $sort = 2;
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
                // TextColumn::make('category')
                //     ->label('Category'),
                TextColumn::make('stock')
                    ->badge()
                    ->color('danger'),
            ]);
    }
}
