<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice',
        'slug',
        'status',
        'total_amount',
        'payment_method',
        'note',
        'wedding_date'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->slug = static::generateSlug($order->invoice);
        });

        static::updating(function ($order) {
            $order->slug = static::generateSlug($order->invoice);
        });
    }

    public static function generateSlug($invoice)
    {
        return str::slug($invoice, '-');
    }

    /**
     * Get all of the Items for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the couriers for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function couriers(): HasMany
    {
        return $this->hasMany(Courier::class);
    }
}
