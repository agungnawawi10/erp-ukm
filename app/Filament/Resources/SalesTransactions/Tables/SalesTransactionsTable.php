<?php

namespace App\Filament\Resources\SalesTransactions\Tables;

use App\Services\InventoryService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class SalesTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->searchable(),

                TextColumn::make('customer.name')
                    ->sortable(),

                TextColumn::make('transaction_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('grand_total')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn($record) => $record->status === 'draft'),

                Action::make('complete')
                    ->label('Complete')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'draft')
                    ->action(function ($record) {

                        if ($record->status !== 'draft') {
                            return;
                        }

                        if ($record->items->isEmpty()) {
                            throw new \Exception('Sales transaction has no items.');
                        }

                        DB::transaction(function () use ($record) {

                            $inventoryService = app(InventoryService::class);

                            foreach ($record->items as $item) {

                                $inventoryService->stockOut(
                                    $item->product,
                                    $item->quantity,
                                    'Sales Invoice ' . $record->invoice_number
                                );
                            }

                            $record->update([
                                'status' => 'completed',
                            ]);
                        });
                    }),

                Action::make('print')
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->color('info')
                    ->visible(fn($record) => $record->status === 'completed')
                    ->url(fn($record) => route('invoice.print', $record))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
