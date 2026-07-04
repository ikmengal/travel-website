<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'featured' => 'boolean',
        'popular' => 'boolean',
        'status' => 'boolean',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Parent Relations
    |--------------------------------------------------------------------------
    */

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function category()
    {
        return $this->belongsTo(TourCategory::class,'tour_category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Child Relations
    |--------------------------------------------------------------------------
    */

    public function images()
    {
        return $this->hasMany(TourImage::class)
            ->orderBy('sort_order');
    }

    public function itineraries()
    {
        return $this->hasMany(TourItinerary::class)
            ->orderBy('day');
    }

    public function includes()
    {
        return $this->hasMany(TourInclude::class);
    }

    public function excludes()
    {
        return $this->hasMany(TourExclude::class);
    }

    public function departures()
    {
        return $this->hasMany(TourDeparture::class)
            ->orderBy('departure_date');
    }

    /*
    |--------------------------------------------------------------------------
    | Future Modules
    |--------------------------------------------------------------------------
    */

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->morphMany(
            Review::class,
            'reviewable'
        );
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
}
