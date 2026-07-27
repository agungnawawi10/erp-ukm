<?php

use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PurchaseReportsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('purchase_number')
          ->label('Purchase No')
          ->searchable(),

        TextColumn::make('supplier.name')
          ->label('Supplier')
          ->searchable()
          ->sortable(),

        TextColumn::make('order_date')
          ->label('Tanggal')
          ->date()
          ->sortable(),

        TextColumn::make('grand_total')
          ->money('IDR')
          ->summarize(
            Sum::make()->money('IDR')
          ),

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
        Filter::make('Tanggal')
          ->schema([
            DatePicker::make('from'),
            DatePicker::make('until'),
          ])
          ->query(function ($query, array $data) {
            return $query
              ->when(
                $data['from'],
                fn($query) => $query->whereDate('order_date', '>=', $data['from'])
              )
              ->when(
                $data['until'],
                fn($query) => $query->whereDate('order_date', '<=', $data['until'])
              );
          }),

        SelectFilter::make('supplier_id')
          ->relationship('supplier', 'name'),
      ]);
  }
}
