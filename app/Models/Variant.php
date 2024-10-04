<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'product_id', 'description', 'price',
    ];

    /**
     * Get the product that owns the Variant
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get all of the carts for the Variant
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get all of the Orders for the Variant
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function formatRupiah($amount)
    {
        return 'Rp '.number_format($amount, 0, ',', '.');
    }
}
