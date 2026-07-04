<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Airport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'country_id',
        'state_id',
        'city_id',
        'name',
        'slug',
        'iata_code',
        'icao_code',
        'airport_code',
        'terminal',
        'address',
        'latitude',
        'longitude',
        'international',
        'featured',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'international'=>'boolean',
        'featured'=>'boolean',
        'status'=>'boolean',
    ];

    // ------------------------------------- Relationships ------------------------------------- //
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    // public function departureFlights()
    // {
    //     return $this->hasMany(
    //         Flight::class,
    //         'departure_airport_id'
    //     );
    // }

    // public function arrivalFlights()
    // {
    //     return $this->hasMany(
    //         Flight::class,
    //         'arrival_airport_id'
    //     );
    // }

    // ------------------------------------- Scopes ------------------------------------- //
    public function scopeActive($query)
    {
        return $query->where('status',true);
    }

    public function scopeInternational($query)
    {
        return $query->where('international',true);
    }
}
