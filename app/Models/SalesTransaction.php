<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesTransaction extends Model
{
    protected $fillable = [
        'invoice_number',
        'customer_id',
        'transaction_date',
        'grand_total',
        'notes',
        'created_by',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(SalesTransactionItem::class);
    }

    public static function generateInvoiceNumber(): string
    {
        $prefix = 'INV-' . now()->format('Ym');

        $lastInvoice = self::where('invoice_number', 'like', $prefix . '-%')
            ->latest('id')
            ->first();

        if (! $lastInvoice) {
            return $prefix . '-0001';
        }

        $lastNumber = (int) substr($lastInvoice->invoice_number, -4);

        return $prefix . '-' . str_pad(
            $lastNumber + 1,
            4,
            '0',
            STR_PAD_LEFT
        );
    }
}
