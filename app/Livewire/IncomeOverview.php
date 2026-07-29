<?php

namespace App\Livewire;

use App\Models\Income;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IncomeOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Income Today (Pemasukan Hari Ini)
        $incomeToday = Income::whereDate('income_date', Carbon::today())->sum('amount') ?? 0;

        // 2. Income This Month (Pemasukan Bulan Ini)
        $incomeThisMonth = Income::whereMonth('income_date', Carbon::now()->month)
            ->whereYear('income_date', Carbon::now()->year)
            ->sum('amount') ?? 0;

        // 3. Total Income (Akumulasi Seluruh Pemasukan)
        $totalIncome = Income::sum('amount') ?? 0;

        // 4. Average Daily Income (Rata-rata Pemasukan Harian Bulan Ini)
        // Menghitung total pemasukan bulan ini dibagi jumlah hari yang sudah berjalan di bulan ini
        $currentDay = Carbon::now()->day; // contoh: tanggal 15 -> dibagi 15 hari
        $averageDailyIncome = $currentDay > 0 ? $incomeThisMonth / $currentDay : 0;

        return [
            Stat::make('Income Today', 'Rp ' . number_format($incomeToday, 0, ',', '.'))
                ->description('Pemasukan hari ini')
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Income This Month', 'Rp ' . number_format($incomeThisMonth, 0, ',', '.'))
                ->description('Pemasukan bulan ' . Carbon::now()->translatedFormat('F'))
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),

            Stat::make('Total Income', 'Rp ' . number_format($totalIncome, 0, ',', '.'))
                ->description('Total akumulasi kas masuk')
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Average Daily Income', 'Rp ' . number_format($averageDailyIncome, 0, ',', '.'))
                ->description('Rata-rata per hari bulan ini')
                ->icon('heroicon-o-calculator')
                ->color('info'),
        ];
    }
}
