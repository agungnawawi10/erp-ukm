<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. Tampilkan SKU paling atas
                TextInput::make('sku')
                    ->default(fn() => 'PRD-' . now()->format('YmdHis'))
                    ->disabled()
                    ->dehydrated(),

                // 2. Nama Produk
                TextInput::make('name')
                    ->required(),

                // 3. Dropdown Kategori 
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload() 
                    ->required(),

                // 4. Dropdown Supplier 
                Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->searchable()
                    ->preload(), 

                // 5. Harga Beli
                TextInput::make('purchase_price')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rp'), 

                // 6. Harga Jual
                TextInput::make('selling_price')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rp'),

                // 7. Stok
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),

                // 8. Upload Gambar 
                FileUpload::make('image')
                    ->image()
                    ->directory('products') 
                    ->imageEditor()
                    ->columnSpanFull(),

                // 9. Deskripsi
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}