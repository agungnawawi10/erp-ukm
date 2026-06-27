<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'sales_transaction_id',
        'income_date',
        'amount',
        'description',
    ];

    public function salesTransaction()
    {
        return $this->belongsTo(SalesTransaction::class);
    }
}
