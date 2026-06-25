<?php

namespace App\Filament\Resources\SalesTransactions\RelationManagers;

use App\Models\Product;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($state, $get, $set) {
                        if ($state) {
                            $product = Product::find($state);
                            if ($product) {
                                $set('unit_price', $product->selling_price);

                                $quantity = $get('quantity') ?? 1;
                                if (!$get('quantity')) {
                                    $set('quantity', 1);
                                }

                                $set('subtotal', $quantity * $product->selling_price);
                            }
                        } else {
                            $set('unit_price', null);
                            $set('subtotal', null);
                        }
                    }),

                TextInput::make('quantity')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->live()
                    // ->disabled()
                    ->afterStateUpdated(function ($state, $get, $set) {

                        $price = $get('unit_price') ?? 0;

                        $set('subtotal', $state * $price);
                    }),

                TextInput::make('unit_price')
                    ->numeric()
                    ->required(),

                TextInput::make('subtotal')
                    ->numeric()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_id')
            ->columns([
                TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable(),

                TextColumn::make('quantity'),

                TextColumn::make('unit_price')
                    ->money('IDR'),

                TextColumn::make('subtotal')
                    ->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->after(function ($record) {

                        $record->salesTransaction
                            ->recalculateGrandTotal();
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->after(function ($record) {

                        $record->salesTransaction
                            ->recalculateGrandTotal();
                    }),
                DeleteAction::make()
                    ->after(function ($record) {

                        $record->salesTransaction
                            ->recalculateGrandTotal();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
