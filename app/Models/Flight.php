<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'airline_id',
        'flight_route_id',
        'departure_airport_id',
        'arrival_airport_id',
        // 'flight_class_id',
        'flight_number',
        'aircraft',
        'departure_date',
        'departure_time',
        'arrival_date',
        'arrival_time',
        'duration',
        'base_price',
        'total_seats',
        'available_seats',
        'baggage',
        'refundable',
        'flight_type',
        'status',
    ];

    protected $casts = [
        'departure_date'=>'date',
        'arrival_date'=>'date',
        'base_price'=>'decimal:2',
        'refundable'=>'boolean',
    ];

    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function route()
    {
        return $this->belongsTo(FlightRoute::class,'flight_route_id');
    }

    public function departureAirport()
    {
        return $this->belongsTo(
            Airport::class,
            'departure_airport_id'
        );
    }

    public function arrivalAirport()
    {
        return $this->belongsTo(
            Airport::class,
            'arrival_airport_id'
        );
    }

    public function schedules()
    {
        return $this->hasMany(FlightSchedule::class);
    }

    public function wishlists()
    {
        return $this->morphMany(
            Wishlist::class,
            'wishlistable'
        );
    }

    public function faqs()
    {
        return $this->morphMany(
            Faq::class,
            'faqable'
        );
    }

    // public function flightClass()
    // {
    //     return $this->belongsTo(FlightClass::class);
    // }
}
