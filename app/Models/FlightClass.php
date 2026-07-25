<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FlightClass extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'baggage',
        'seat_priority',
        'meal',
        'refundable',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'meal'         => 'boolean',
        'refundable'   => 'boolean',
        'status'       => 'boolean',
    ];

    // --------------- Scopes --------------- //
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }
}
