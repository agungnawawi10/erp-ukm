<?php

namespace App\Livewire;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class ProductOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Total Products
        $totalProducts = Product::count();

        // 2. Total Stock
        $totalStock = Product::sum('stock');

        // 3. Total Inventory Value (Asumsi kolom harga: 'price' dan stok: 'stock')
        $totalInventoryValue = Product::selectRaw('SUM(stock * selling_price) as total_value')->value('total_value') ?? 0;

        // 4. Low Stock Products (Misal: stok <= 5 dan > 0)
        $lowStockProducts = Product::where('stock', '<=', 5)->where('stock', '>', 0)->count();

        // 5. Out of Stock Products
        $outOfStockProducts = Product::where('stock', '<=', 0)->count();

        // 6. New Products This Month
        $newProductsThisMonth = Product::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        return [
            Stat::make('Total Products', $totalProducts)
                ->description('Jumlah variasi produk')
                ->icon('heroicon-o-cube')
                ->color('primary'),

            Stat::make('Total Stock', number_format($totalStock))
                ->description('Total stok semua product')
                ->icon('heroicon-o-archive-box')
                ->color('info'),

            Stat::make('Total Inventory Value', 'Rp ' . number_format($totalInventoryValue, 0, ',', '.'))
                ->description('Estimasi nilai aset barang')
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Low Stock Products', $lowStockProducts)
                ->description('Stok terancam habis (<= 5)')
                ->icon('heroicon-o-exclamation-triangle')
                ->color($lowStockProducts > 0 ? 'warning' : 'gray'),

            Stat::make('Out of Stock Products', $outOfStockProducts)
                ->description('Stok benar-benar kosong')
                ->icon('heroicon-o-x-circle')
                ->color($outOfStockProducts > 0 ? 'danger' : 'gray'),

            Stat::make('New Products This Month', $newProductsThisMonth)
                ->description('Ditambahkan bulan ini')
                ->icon('heroicon-o-sparkles')
                ->color('info'),
        ];
    }
}
