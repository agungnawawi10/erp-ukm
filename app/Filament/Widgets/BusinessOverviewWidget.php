<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Product;
use App\Models\SalesTransactionItem;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BusinessOverviewWidget extends StatsOverviewWidget

{
    protected int|string|array $columnSpan = 'full';
    protected function getStats(): array
    {
        $income = Income::sum('amount');

        $expense = Expense::sum('amount');

        $cogs = SalesTransactionItem::with(['product', 'salesTransaction'])
            ->get()
            ->filter(fn($item) => $item->salesTransaction?->status === 'completed')
            ->sum(fn($item) => $item->quantity * $item->product->purchase_price);

        $profit = $income - $expense - $cogs;

        return [
            Stat::make(
                'Total Sales',
                'Rp ' . number_format($income, 0, ',', '.')
            )
                ->description('Total penjualan')
                ->color('success')
                ->icon('heroicon-o-banknotes'),

            Stat::make(
                'Products',
                Product::count()
            )
                ->description('Total produk')
                ->color('info')
                ->icon('heroicon-o-cube'),

            Stat::make(
                'Net Profit',
                'Rp ' . number_format($profit, 0, ',', '.')
            )
                ->description('Laba bersih')
                ->color($profit >= 0 ? 'success' : 'danger')
                ->icon('heroicon-o-chart-bar'),

            Stat::make(
                'Low Stock',
                Product::where('stock', '<=', 10)->count()
            )
                ->description('Produk hampir habis')
                ->color('warning')
                ->icon('heroicon-o-exclamation-triangle'),
        ];
    }
}
