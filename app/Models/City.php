<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $table = 'rajaongkir_cities';

    /**
    * Get all of the addresses for the User
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function addresses(): HasMany
   {
       return $this->hasMany(Address::class);
   }

   /**
     * Get all of the shops for the Province
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class);
    }
}
