<?php

namespace App\Filament\Resources\SalesTransactions\Schemas;

use App\Models\SalesTransaction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SalesTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice_number')
                    ->label('Invoice Number')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->default(fn() => SalesTransaction::generateInvoiceNumber()),
                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('transaction_date')
                    ->default(now())
                    ->required(),
                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('draft')
                    ->required(),
                Textarea::make('notes'),

                Hidden::make('created_by')
                    ->default(fn() => Auth::id()),
            ]);
    }
}
