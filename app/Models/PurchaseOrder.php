<?php

namespace App\Models;

use App\Enums\POStatus;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{

    protected $fillable = ['po_number', 'supplier_id', 'order_date', 'status', 'notes', 'created_by'];
    protected $casts = [
        'status' => POStatus::class,
        'order_date' => 'date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
