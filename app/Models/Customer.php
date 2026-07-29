<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'customer_code',
        'name',
        'email',
        'phone',
        'address',
    ];

    public function orders(): HasMany
{
    return $this->hasMany(SalesTransaction::class); // Sesuaikan nama Model Transaksi/Pesanan Anda
}
}
