<?php

namespace App\Livewire;

use App\Enums\POStatus;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PurchaseOrderOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // 1. Total Purchase Orders
        $totalPOs = PurchaseOrder::count();

        // 2. Purchase Today (Berdasarkan order_date)
        $purchasesToday = PurchaseOrder::whereDate('order_date', Carbon::today())->count();

        // 3. Purchase This Month (Berdasarkan order_date)
        $purchasesThisMonth = PurchaseOrder::whereMonth('order_date', Carbon::now()->month)
            ->whereYear('order_date', Carbon::now()->year)
            ->count();

        // 4. Total Purchase Amount (Mengakumulasi subtotal item transaksi)
        $totalPurchaseAmount = PurchaseOrder::with('items')->get()->sum(function ($po) {
            return $po->items->sum('subtotal'); // Sesuaikan kolom 'subtotal' jika namanya beda
        });

        // 5. Pending Purchase Orders (Status DRAFT atau APPROVED)
        $pendingPOs = PurchaseOrder::whereIn('status', [
            POStatus::DRAFT,
            POStatus::APPROVED,
        ])->count();

        // 6. Completed Purchase Orders (Status RECEIVED)
        $completedPOs = PurchaseOrder::where('status', POStatus::RECEIVED)->count();

        return [
            Stat::make('Total Purchase Orders', number_format($totalPOs))
                ->description('Total akumulasi dokumen PO')
                ->icon('heroicon-o-document-text')
                ->color('primary'),

            Stat::make('Purchase Today', number_format($purchasesToday))
                ->description('PO baru hari ini')
                ->icon('heroicon-o-calendar')
                ->color('info'),

            Stat::make('Purchase This Month', number_format($purchasesThisMonth))
                ->description('PO bulan ' . Carbon::now()->translatedFormat('F'))
                ->icon('heroicon-o-calendar-days')
                ->color('info'),

            Stat::make('Total Purchase Amount', 'Rp ' . number_format($totalPurchaseAmount, 0, ',', '.'))
                ->description('Total pengeluaran belanja ke supplier')
                ->icon('heroicon-o-banknotes')
                ->color('danger'),

            Stat::make('Pending Purchase Orders', number_format($pendingPOs))
                ->description('Status Draft & Approved')
                ->icon('heroicon-o-clock')
                ->color($pendingPOs > 0 ? 'warning' : 'gray'),

            Stat::make('Completed Purchase Orders', number_format($completedPOs))
                ->description('Barang telah diterima (Received)')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
        ];
    }
}
