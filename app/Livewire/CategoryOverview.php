<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CategoryOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Total Kategori
        $totalCategories = Category::count();

        // 2. Rata-rata Produk per Kategori
        // Menghitung total produk dibagi total kategori (mencegah pembagian dengan nol)
        $totalProducts = Product::count();
        $avgProductsPerCategory = $totalCategories > 0
            ? round($totalProducts / $totalCategories, 1)
            : 0;

        // 3. Kategori Terbanyak Dipakai
        // Mengambil kategori yang memiliki relasi produk terbanyak
        $mostUsedCategory = Category::withCount('products')
            ->orderByDesc('products_count')
            ->first();

        $mostUsedLabel = $mostUsedCategory
            ? "{$mostUsedCategory->name} ({$mostUsedCategory->products_count} produk)"
            : 'Belum ada data';

        // 4. Kategori Kosong (Belum Memiliki Produk)
        $emptyCategories = Category::doesntHave('products')->count();

        return [
            Stat::make('Total Categories', $totalCategories)
                ->description('Total seluruh kategori')
                ->icon('heroicon-o-tag')
                ->color('primary'),

            Stat::make('Products per Category', $avgProductsPerCategory)
                ->description('Rata-rata produk per kategori')
                ->icon('heroicon-o-calculator')
                ->color('info'),

            Stat::make('Most Used Category', $mostUsedLabel)
                ->description('Kategori dengan produk terbanyak')
                ->icon('heroicon-o-fire')
                ->color('success'),

            Stat::make('Empty Categories', $emptyCategories)
                ->description('Kategori tanpa produk')
                ->icon('heroicon-o-exclamation-triangle')
                ->color($emptyCategories > 0 ? 'warning' : 'gray'),
        ];
    }
}
