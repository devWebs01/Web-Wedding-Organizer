<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_type',
        'amount',
        'payment_date',
        'payment_status',
        'proof_of_payment',
        'note',
    ];

    // Relasi dengan tabel Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
