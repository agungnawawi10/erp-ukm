<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\StockMovement;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StockMovementOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Stock In Today (Barang Masuk Hari Ini)
        $stockInToday = StockMovement::where('type', 'in')
            ->whereDate('created_at', Carbon::today())
            ->sum('quantity');

        // 2. Stock Out Today (Barang Keluar Hari Ini)
        $stockOutToday = StockMovement::where('type', 'out')
            ->whereDate('created_at', Carbon::today())
            ->sum('quantity');

        // 3. Total Stock In This Month (Total Barang Masuk Bulan Ini)
        $stockInThisMonth = StockMovement::where('type', 'in')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('quantity');

        // 4. Total Stock Out This Month (Total Barang Keluar Bulan Ini)
        $stockOutThisMonth = StockMovement::where('type', 'out')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('quantity');

        // 5. Products Below Minimum Stock
        // Mengambil produk yang stok saat ininya kurang dari <= 5
        $productsBelowMinStock = Product::where('stock', '<=', 5)->count();

        return [
            Stat::make('Stock In Today', number_format($stockInToday) . ' unit')
                ->description('Barang masuk hari ini')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success'),

            Stat::make('Stock Out Today', number_format($stockOutToday) . ' unit')
                ->description('Barang keluar hari ini')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('danger'),

            Stat::make('Total Stock In This Month', number_format($stockInThisMonth) . ' unit')
                ->description('Masuk bulan ' . Carbon::now()->translatedFormat('F'))
                ->icon('heroicon-o-archive-box-arrow-down')
                ->color('info'),

            Stat::make('Total Stock Out This Month', number_format($stockOutThisMonth) . ' unit')
                ->description('Keluar bulan ' . Carbon::now()->translatedFormat('F'))
                ->icon('heroicon-o-archive-box')
                ->color('warning'),

            Stat::make('Products Below Minimum Stock', number_format($productsBelowMinStock))
                ->description('Stok di bawah batas minimum')
                ->icon('heroicon-o-exclamation-triangle')
                ->color($productsBelowMinStock > 0 ? 'danger' : 'gray'),
        ];
    }
}
