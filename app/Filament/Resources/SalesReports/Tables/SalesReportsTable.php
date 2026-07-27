<?php

use Filament\Forms\Components\DatePicker;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SalesReportTable
{
  public static function configure(Table $table): Table
  {
    return $table
    ->headerActions([
      Action::make('export')
        ->label('Export Excel')
        ->icon('heroicon-o-arrow-down-tray')
        ->url(fn ($livewire): string => route('sales-reports.export', [
          'tableFilters' => $livewire->tableFilters ?? [],
        ]))
        ->openUrlInNewTab(),
    ])
    ->columns([
        TextColumn::make('invoice_number')
          ->label('Invoice')
          ->searchable(),

        TextColumn::make('customer.name')
          ->label('Customer')
          ->searchable()
          ->sortable(),

        TextColumn::make('transaction_date')
          ->label('Date')
          ->date()
          ->sortable(),

        TextColumn::make('grand_total')
          ->label('Grand Total')
          ->money('IDR')
          ->sortable(),

        TextColumn::make('status')
          ->badge()
          ->color(fn(string $state) => match ($state) {
            'draft' => 'gray',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'gray',
          }),
      ])
      ->filters([
        Filter::make('transaction_date')
          ->schema([
            DatePicker::make('from'),
            DatePicker::make('until'),
          ])
          ->query(function ($query, array $data) {
            return $query
              ->when(
                $data['from'],
                fn($query) => $query->whereDate('transaction_date', '>=', $data['from']),
              )
              ->when(
                $data['until'],
                fn($query) => $query->whereDate('transaction_date', '<=', $data['until']),
              );
          }),
        SelectFilter::make('status')
          ->options([
            'draft' => 'Draft',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
          ]),
        SelectFilter::make('customer_id')
          ->relationship('customer', 'name')
      ]);
  }
}
