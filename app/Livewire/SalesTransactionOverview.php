<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\SalesTransaction;
use App\Models\SalesTransactionItem;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class SalesTransactionOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Total Sales (Akumulasi Omzet Seluruh Penjualan)
        $totalSales = SalesTransaction::sum('grand_total') ?? 0;

        // 2. Sales Today (Omzet Hari Ini berdasarkan transaction_date)
        $salesToday = SalesTransaction::whereDate('transaction_date', Carbon::today())
            ->sum('grand_total') ?? 0;

        // 3. Sales This Month (Omzet Bulan Ini)
        $salesThisMonth = SalesTransaction::whereMonth('transaction_date', Carbon::now()->month)
            ->whereYear('transaction_date', Carbon::now()->year)
            ->sum('grand_total') ?? 0;

        // 4. Transactions Today (Jumlah Struk Hari Ini)
        $transactionsToday = SalesTransaction::whereDate('transaction_date', Carbon::today())->count();

        // 5. Average Transaction Value (AOV - Rata-rata Nilai per Transaksi)
        $totalTransactionsCount = SalesTransaction::count();
        $averageTransactionValue = $totalTransactionsCount > 0
            ? $totalSales / $totalTransactionsCount
            : 0;

        // 6. Best Selling Product (Mengambil langsung dari SalesTransactionItem)
        // Menghitung kuantitas terbanyak berdasarkan produk
        $topItem = SalesTransactionItem::select('product_id')
            ->selectRaw('SUM(quantity) as total_qty')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product') // Asumsi di SalesTransactionItem ada relasi belongsTo(Product::class)
            ->first();

        $bestSellingLabel = ($topItem && $topItem->product)
            ? "{$topItem->product->name} ({$topItem->total_qty} terjual)"
            : 'Belum ada data';

        return [
            Stat::make('Total Sales', 'Rp ' . number_format($totalSales, 0, ',', '.'))
                ->description('Total seluruh omzet penjualan')
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Sales Today', 'Rp ' . number_format($salesToday, 0, ',', '.'))
                ->description('Omzet masuk hari ini')
                ->icon('heroicon-o-currency-dollar')
                ->color('info'),

            Stat::make('Sales This Month', 'Rp ' . number_format($salesThisMonth, 0, ',', '.'))
                ->description('Omzet bulan ' . Carbon::now()->translatedFormat('F'))
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),

            Stat::make('Transactions Today', number_format($transactionsToday) . ' Transaksi')
                ->description('Jumlah transaksi hari ini')
                ->icon('heroicon-o-shopping-bag')
                ->color('info'),

            Stat::make('Average Transaction Value', 'Rp ' . number_format($averageTransactionValue, 0, ',', '.'))
                ->description('Rata-rata belanja per transaksi (AOV)')
                ->icon('heroicon-o-calculator')
                ->color('warning'),

            Stat::make('Best Selling Product', $bestSellingLabel)
                ->description('Produk paling laris')
                ->icon('heroicon-o-fire')
                ->color('danger'),
        ];
    }
}
