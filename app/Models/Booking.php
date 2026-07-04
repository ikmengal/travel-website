<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_no',
        'user_id',
        'tour_id',
        'tour_departure_id',

        'adults',
        'children',
        'infants',

        'tour_price',
        'subtotal',
        'discount',
        'tax',
        'grand_total',

        'currency',

        'booking_status',
        'payment_status',

        'special_request',

        'confirmed_at',
        'cancelled_at',
        'completed_at',
    ];

    protected $casts = [

        'tour_price'     => 'decimal:2',
        'subtotal'       => 'decimal:2',
        'discount'       => 'decimal:2',
        'tax'            => 'decimal:2',
        'grand_total'    => 'decimal:2',

        'confirmed_at'   => 'datetime',
        'cancelled_at'   => 'datetime',
        'completed_at'   => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Booking belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Booking belongs to Tour
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    // Booking belongs to Departure Date
    public function departure()
    {
        return $this->belongsTo(TourDeparture::class, 'tour_departure_id');
    }

    // Booking has many Travelers
    public function travelers()
    {
        return $this->hasMany(BookingTraveler::class);
    }

    // Booking has many Payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Booking has many Notes
    public function notes()
    {
        return $this->hasMany(BookingNote::class);
    }

    // Booking has many Status History
    public function statusHistories()
    {
        return $this->hasMany(BookingStatusHistory::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('booking_status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('booking_status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('booking_status', 'cancelled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('booking_status', 'completed');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getTotalTravelersAttribute()
    {
        return $this->adults + $this->children + $this->infants;
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->grand_total, 2);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
