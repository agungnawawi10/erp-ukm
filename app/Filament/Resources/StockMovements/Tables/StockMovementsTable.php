<?php

namespace App\Filament\Resources\StockMovements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StockMovementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->label('Product')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'IN' => 'success',
                        'OUT' => 'danger',
                        'ADJUSTMENT' => 'warning',
                    }),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_before')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stock_after')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('notes')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Created By')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
