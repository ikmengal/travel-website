<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class HotelType extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status' => 'boolean',
    ];

     /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function hotels(): HasMany
    {
        return $this->hasMany(Hotel::class);
    }
}
