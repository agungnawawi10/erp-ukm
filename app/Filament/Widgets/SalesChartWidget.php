<?php

namespace App\Filament\Widgets;

use App\Models\SalesTransaction;
use Filament\Widgets\ChartWidget;

class SalesChartWidget extends ChartWidget
{
    protected ?string $heading = 'Sales Chart';
    protected function getData(): array
    {
        $sales = SalesTransaction::query()
            ->selectRaw('MONTH(transaction_date) as month, SUM(grand_total) as total')
            ->where('status', 'completed')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $sales->pluck('total')->toArray(),
                ],
            ],
            'labels' => $sales
                ->pluck('month')
                ->map(fn($month) => date('M', mktime(0, 0, 0, $month, 1)))
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
