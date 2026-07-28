<?php

namespace App\Filament\Resources\PurchaseReports;

use App\Filament\Resources\BaseResource;
use App\Filament\Resources\PurchaseReports\Pages\ManagePurchaseReports;
use App\Models\PurchaseOrder;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use PurchaseReportsTable;

class PurchaseReportResource extends BaseResource
{
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $navigationLabel = 'Purcahse Report';

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';

    public static function getModelLabel(): string
    {
        return 'Purchase Report';
    }

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ShoppingBag;

    protected static ?string $recordTitleAttribute = 'purchase_number';

    public static function canViewAny(): bool
    {
        return static::hasRole('manager');
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', 'completed');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('purchase_number'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return PurchaseReportsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePurchaseReports::route('/'),
        ];
    }
}
