<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourDeparture extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'departure_date' => 'date',
        'return_date' => 'date',
        'status' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
