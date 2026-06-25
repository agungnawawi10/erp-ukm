<?php

namespace App\Filament\Resources\SalesTransactions;

use App\Filament\Resources\SalesTransactions\Pages\CreateSalesTransaction;
use App\Filament\Resources\SalesTransactions\Pages\EditSalesTransaction;
use App\Filament\Resources\SalesTransactions\Pages\ListSalesTransactions;
use App\Filament\Resources\SalesTransactions\Schemas\SalesTransactionForm;
use App\Filament\Resources\SalesTransactions\Tables\SalesTransactionsTable;
use App\Models\SalesTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SalesTransactionResource extends Resource
{
    protected static ?string $model = SalesTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Sales';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SalesTransactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SalesTransactionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSalesTransactions::route('/'),
            'create' => CreateSalesTransaction::route('/create'),
            'edit' => EditSalesTransaction::route('/{record}/edit'),
        ];
    }
}
