<?php

namespace App\Livewire;

use App\Models\SalesTransaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class SalesTransactionOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Total Orders (Seluruh Transaksi)
        $totalOrders = SalesTransaction::count();

        // 2. Transaksi Hari Ini
        $ordersToday = SalesTransaction::whereDate('created_at', Carbon::today())->count();

        // 3. Transaksi Bulan Ini
        $ordersThisMonth = SalesTransaction::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // 4. Total Amount (Nominal Uang dari Seluruh Transaksi / Transaksi Selesai)
        // Asumsi nama kolom harga total adalah 'total_amount' atau 'grand_total'
        $totalAmount = SalesTransaction::sum('grand_total') ?? 0;

        // 5. Pending Orders (Asumsi kolom status = 'pending')
        $pendingOrders = SalesTransaction::where('status', 'pending')->count();

        // 6. Completed Orders (Asumsi kolom status = 'completed' atau 'paid')
        $completedOrders = SalesTransaction::where('status', 'completed')->count();

        return [
            Stat::make('Total Orders', number_format($totalOrders))
                ->description('Total akumulasi transaksi')
                ->icon('heroicon-o-shopping-cart')
                ->color('primary'),

            Stat::make('Orders Today', number_format($ordersToday))
                ->description('Transaksi masuk hari ini')
                ->icon('heroicon-o-calendar')
                ->color('info'),

            Stat::make('Orders This Month', number_format($ordersThisMonth))
                ->description('Transaksi bulan ' . Carbon::now()->translatedFormat('F'))
                ->icon('heroicon-o-calendar-days')
                ->color('info'),

            Stat::make('Total Amount', 'Rp ' . number_format($totalAmount, 0, ',', '.'))
                ->description('Total omzet / nilai transaksi')
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Pending Orders', number_format($pendingOrders))
                ->description('Transaksi menunggu diproses')
                ->icon('heroicon-o-clock')
                ->color($pendingOrders > 0 ? 'warning' : 'gray'),

            Stat::make('Completed Orders', number_format($completedOrders))
                ->description('Transaksi berhasil / selesai')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
        ];
    }
}
