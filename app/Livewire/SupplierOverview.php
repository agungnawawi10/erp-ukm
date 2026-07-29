<?php

namespace App\Livewire;

use App\Models\Supplier;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class SupplierOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Total Suppliers
        $totalSuppliers = Supplier::count();

        $activeSuppliers = Supplier::has('purchases')->count();

        // 3. Supplier dengan Pembelian Terbanyak (Most Purchases)
        // Mengambil supplier yang paling banyak memiliki relasi transaksi pembelian (purchases/orders)
        $topSupplier = Supplier::withCount('purchases')
            ->orderByDesc('purchases_count')
            ->first();

        $topSupplierLabel = $topSupplier && $topSupplier->purchases_count > 0
            ? "{$topSupplier->name} ({$topSupplier->purchases_count} transaksi)"
            : 'Belum ada transaksi';

        // 4. New Suppliers This Month
        $newSuppliersThisMonth = Supplier::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        return [
            Stat::make('Total Suppliers', $totalSuppliers)
                ->description('Total pemasok terdaftar')
                ->icon('heroicon-o-truck')
                ->color('primary'),

            Stat::make('Active Suppliers', $activeSuppliers)
                ->description('Pemasok status aktif')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Suppliers with Most Purchases', $topSupplierLabel)
                ->description('Pemasok transaksi terbanyak')
                ->icon('heroicon-o-trophy')
                ->color('warning'),

            Stat::make('New Suppliers This Month', $newSuppliersThisMonth)
                ->description('Pemasok baru bulan ini')
                ->icon('heroicon-o-user-plus')
                ->color('info'),
        ];
    }
}

