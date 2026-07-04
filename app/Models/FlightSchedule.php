<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'flight_id',
        'departure_date',
        'arrival_date',
        'departure_time',
        'arrival_time',
        'duration',
        'price',
        'discount_price',
        'total_seats',
        'available_seats',
        'status',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'arrival_date' => 'date',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
    ];

    // ------------------------------------- Relationships ------------------------------------- //
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    // ------------------------------------- Scopes ------------------------------------- //
    public function scopeUpcoming($query)
    {
        return $query->whereDate('departure_date','>=',today());
    }

    public function scopeAvailable($query)
    {
        return $query->where('available_seats','>',0);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status','scheduled');
    }

    // ------------------------------------- Accessors ------------------------------------- //
    public function getCurrentPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }
}
