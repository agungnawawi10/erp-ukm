<?php

namespace App\Filament\Widgets;

use App\Models\SalesTransaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalSalesWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Total Sales',
                'Rp ' . number_format(
                    SalesTransaction::where('status', 'completed')
                        ->sum('grand_total')
                )
            )
                ->description('Total penjualan selesai')
                ->icon('heroicon-o-banknotes'),
        ];
    }
}
