<?php

namespace App\Filament\Resources\PurchaseOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PurchaseOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('po_number')
                    ->searchable(),

                // 1. Mengubah supplier_id menjadi nama supplier lewat relasi
                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('order_date')
                    ->date()
                    ->sortable(),

                // Opsional: Membuat status menjadi badge agar lebih menarik
                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state): string => match ($state?->value ?? $state) {
                        'draft' => 'gray',
                        'approved' => 'info',
                        'received' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),

                // 2. Mengubah created_by menjadi nama user pembuat lewat relasi
                TextColumn::make('creator.name')
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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
