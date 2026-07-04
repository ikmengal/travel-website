<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'departure_airport_id',
        'arrival_airport_id',
        'route_code',
        'distance',
        'estimated_duration',
        'status'
    ];

    protected $casts = [
        'distance'=>'decimal:2',
        'status'=>'boolean',
    ];

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

    // public function flights()
    // {
    //     return $this->hasMany(Flight::class);
    // }
}
