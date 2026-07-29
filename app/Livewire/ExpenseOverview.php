<?php

namespace App\Livewire;

use App\Models\Expense;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class ExpenseOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Expense Today (Pengeluaran Hari Ini)
        $expenseToday = Expense::whereDate('expense_date', Carbon::today())->sum('amount') ?? 0;

        // 2. Expense This Month (Pengeluaran Bulan Ini)
        $expenseThisMonth = Expense::whereMonth('expense_date', Carbon::now()->month)
            ->whereYear('expense_date', Carbon::now()->year)
            ->sum('amount') ?? 0;

        // 3. Total Expense (Akumulasi Seluruh Pengeluaran)
        $totalExpense = Expense::sum('amount') ?? 0;

        // 4. Largest Expense This Month (Pengeluaran Terbesar Bulan Ini)
        $largestExpense = Expense::whereMonth('expense_date', Carbon::now()->month)
            ->whereYear('expense_date', Carbon::now()->year)
            ->orderByDesc('amount')
            ->first();

        $largestExpenseLabel = $largestExpense && $largestExpense->amount > 0
            ? "Rp " . number_format($largestExpense->amount, 0, ',', '.') . " ({$largestExpense->category})"
            : 'Belum ada data';

        return [
            Stat::make('Expense Today', 'Rp ' . number_format($expenseToday, 0, ',', '.'))
                ->description('Pengeluaran hari ini')
                ->icon('heroicon-o-arrow-trending-down')
                ->color('danger'),

            Stat::make('Expense This Month', 'Rp ' . number_format($expenseThisMonth, 0, ',', '.'))
                ->description('Bulan ' . Carbon::now()->translatedFormat('F'))
                ->icon('heroicon-o-calendar')
                ->color('warning'),

            Stat::make('Total Expense', 'Rp ' . number_format($totalExpense, 0, ',', '.'))
                ->description('Total akumulasi kas keluar')
                ->icon('heroicon-o-banknotes')
                ->color('danger'),

            Stat::make('Largest Expense This Month', $largestExpenseLabel)
                ->description('Pengeluaran terbesar bulan ini')
                ->icon('heroicon-o-fire')
                ->color('danger'),
        ];
    }
}
