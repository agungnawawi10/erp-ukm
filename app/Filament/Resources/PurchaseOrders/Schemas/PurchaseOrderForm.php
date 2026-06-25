<?php

namespace App\Filament\Resources\PurchaseOrders\Schemas;

use App\Enums\POStatus as EnumsPOStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PurchaseOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('po_number')
                    ->label('PO Number')
                    ->disabled() // 👈 Kunci input agar tidak bisa diubah manual oleh user
                    ->dehydrated() // 👈 Tetap simpan nilainya ke database meskipun statusnya disabled
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    // 👈 Logika untuk generate nomor otomatis saat form create dibuka:
                    ->default(fn() => 'PO-' . date('Ymd') . '-' . strtoupper(Str::random(4))),
                Select::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('order_date')
                    ->required(),
                TextInput::make('status')
                    ->label('Status')
                    ->default(EnumsPOStatus::DRAFT->value)
                    ->disabled()
                    ->dehydrated(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                Hidden::make('created_by')
                    ->default(fn() => Auth::id()),
            ]);
    }
}
