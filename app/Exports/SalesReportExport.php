<?php

namespace App\Exports;

use App\Models\SalesTransaction;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesReportExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->query()
            ->get()
            ->map(function ($sale) {
                return [
                    'Invoice' => $sale->invoice_number,
                    'Customer' => $sale->customer?->name,
                    'Date' => $sale->transaction_date,
                    'Grand Total' => $sale->grand_total,
                    'Status' => $sale->status,
                ];
            });
    }

    protected function query(): Builder
    {
        $filters = request()->input('tableFilters', []);

        $query = SalesTransaction::query()
            ->with('customer')
            ->where('status', 'completed');

        $transactionDateFilter = $filters['transaction_date'] ?? null;

        if (is_array($transactionDateFilter)) {
            $query
                ->when(
                    filled($transactionDateFilter['from'] ?? null),
                    fn (Builder $query) => $query->whereDate('transaction_date', '>=', $transactionDateFilter['from']),
                )
                ->when(
                    filled($transactionDateFilter['until'] ?? null),
                    fn (Builder $query) => $query->whereDate('transaction_date', '<=', $transactionDateFilter['until']),
                );
        }

        $statusFilter = $filters['status'] ?? null;

        if (is_array($statusFilter)) {
            if (filled($statusFilter['value'] ?? null)) {
                $query->where('status', $statusFilter['value']);
            }

            if (! empty($statusFilter['values'] ?? [])) {
                $query->whereIn('status', $statusFilter['values']);
            }
        }

        $customerFilter = $filters['customer_id'] ?? null;

        if (is_array($customerFilter)) {
            if (filled($customerFilter['value'] ?? null)) {
                $query->where('customer_id', $customerFilter['value']);
            }

            if (! empty($customerFilter['values'] ?? [])) {
                $query->whereIn('customer_id', $customerFilter['values']);
            }
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Invoice',
            'Customer',
            'Transaction Date',
            'Grand Total',
            'Status',
        ];
    }
}
