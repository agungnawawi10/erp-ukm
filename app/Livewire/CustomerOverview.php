<?php

namespace App\Livewire;

use App\Models\Customer;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Total Customers
        $totalCustomers = Customer::count();

        // 2. Active Customers (yang pernah transaksi)
        $activeCustomers = Customer::has('orders')->count();

        // 3. New Customers This Month
        $newCustomersThisMonth = Customer::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // 4. Top Customer (Pelanggan dengan transaksi terbanyak)
        $topCustomer = Customer::withCount('orders')
            ->orderByDesc('orders_count')
            ->first();

        $topCustomerLabel = $topCustomer && $topCustomer->orders_count > 0
            ? "{$topCustomer->name} ({$topCustomer->orders_count} pesanan)"
            : '-';

        return [
            Stat::make('Total Customers', $totalCustomers)
                ->description('Total pelanggan terdaftar')
                ->icon('heroicon-o-users')
                ->color('primary'),

            Stat::make('Active Customers', $activeCustomers)
                ->description('Pelanggan yang aktif bertransaksi')
                ->icon('heroicon-o-check-circle') 
                ->color('success'),

            Stat::make('New Customers This Month', $newCustomersThisMonth)
                ->description('Pelanggan baru bulan ini')
                ->icon('heroicon-o-user-plus')
                ->color('info'),

            Stat::make('Top Customer', $topCustomerLabel)
                ->description('Pelanggan paling sering belanja')
                ->icon('heroicon-o-star')
                ->color('warning'),
        ];
    }
}
