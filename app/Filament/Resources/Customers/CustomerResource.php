<?php

namespace App\Filament\Resources\Customers;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\Customers\Pages\CreateCustomer;
use App\Filament\Resources\Customers\Pages\EditCustomer;
use App\Filament\Resources\Customers\Pages\ListCustomers;
use App\Filament\Resources\Customers\Schemas\CustomerForm;
use App\Filament\Resources\Customers\Tables\CustomersTable;
use App\Models\Customer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CustomerResource extends BaseResource
{
    protected static ?string $model = Customer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|\UnitEnum|null $navigationGroup = 'Sales';


    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewAny(): bool
    {
        return static::hasRoles([
            'manager',
            'warehouse',
            'cashier',
        ]);
    }

    public static function canCreate(): bool
    {
        return static::hasRoles([
            'cashier',
        ]);
    }

    public static function canEdit($record): bool
    {
        return static::hasRole('cashier');
    }

    public static function canDelete($record): bool
    {
        return static::hasRole('cashier');
    }

    public static function form(Schema $schema): Schema
    {
        return CustomerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCustomers::route('/'),
            'create' => CreateCustomer::route('/create'),
            'edit' => EditCustomer::route('/{record}/edit'),
        ];
    }
}
