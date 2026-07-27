<?php

namespace App\Filament\Resources\SalesReports;

use App\Filament\Resources\SalesReports\Pages\ManageSalesReports;
use App\Models\SalesTransaction;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use SalesReportTable;

class SalesReportResource extends Resource
{
    protected static ?string $model = SalesTransaction::class;

    protected static ?string $navigationLabel = 'Sales Report';

    protected static string|\UnitEnum|null $navigationGroup = 'Reports';

    public static function getModelLabel(): string
    {
        return 'Sales Report';
    }
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?string $recordTitleAttribute = 'name';


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', 'completed');
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('invoice_number'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return SalesReportTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSalesReports::route('/'),
        ];
    }
}
