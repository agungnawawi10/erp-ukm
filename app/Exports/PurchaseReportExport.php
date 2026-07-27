<?php

namespace App\Exports;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return $this->query()
            ->get()
            ->map(function ($purchase) {
                return [
                    'Purchase Number' => $purchase->purchase_number,
                    'Supplier'        => $purchase->supplier?->name,
                    'Order Date'      => $purchase->order_date,
                    'Grand Total'     => $purchase->grand_total,
                    'Status'          => $purchase->status,
                ];
            });
    }

    protected function query(): Builder
    {
        $filters = request()->input('tableFilters', []);

        $query = PurchaseOrder::query()
            ->with('supplier')
            ->where('status', 'completed');

        // Filter tanggal
        $orderDateFilter = $filters['order_date'] ?? null;

        if (is_array($orderDateFilter)) {
            $query
                ->when(
                    filled($orderDateFilter['from'] ?? null),
                    fn (Builder $query) => $query->whereDate('order_date', '>=', $orderDateFilter['from']),
                )
                ->when(
                    filled($orderDateFilter['until'] ?? null),
                    fn (Builder $query) => $query->whereDate('order_date', '<=', $orderDateFilter['until']),
                );
        }

        // Filter status
        $statusFilter = $filters['status'] ?? null;

        if (is_array($statusFilter)) {
            if (filled($statusFilter['value'] ?? null)) {
                $query->where('status', $statusFilter['value']);
            }

            if (! empty($statusFilter['values'] ?? [])) {
                $query->whereIn('status', $statusFilter['values']);
            }
        }

        // Filter supplier
        $supplierFilter = $filters['supplier_id'] ?? null;

        if (is_array($supplierFilter)) {
            if (filled($supplierFilter['value'] ?? null)) {
                $query->where('supplier_id', $supplierFilter['value']);
            }

            if (! empty($supplierFilter['values'] ?? [])) {
                $query->whereIn('supplier_id', $supplierFilter['values']);
            }
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Purchase Number',
            'Supplier',
            'Order Date',
            'Grand Total',
            'Status',
        ];
    }
}