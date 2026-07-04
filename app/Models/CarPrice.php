<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarPrice extends Model
{
    use HasFactory;

    protected $fillable = [

        'car_id',

        'title',

        'price_type',

        'start_date',

        'end_date',

        'price_per_day',

        'discount_price',

        'minimum_days',

        'priority',

        'status',

    ];

    protected $casts = [

        'start_date' => 'date',

        'end_date' => 'date',

        'price_per_day' => 'decimal:2',

        'discount_price' => 'decimal:2',

        'status' => 'boolean',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeCurrent($query)
    {
        return $query->whereDate('start_date', '<=', now())
                     ->whereDate('end_date', '>=', now());
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getCurrentPriceAttribute()
    {
        return $this->discount_price ?? $this->price_per_day;
    }
}
