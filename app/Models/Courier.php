<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Support\Number;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courier extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'value', 'etd', 'order_id'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getFormattedDescriptionAttribute()
    {
        return $this->description . ' ' . $this->etd . ' Hari - Rp. ' . Number::format($this->value, locale: 'id');
    }
}
