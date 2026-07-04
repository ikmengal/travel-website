<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'destination_id',

        'name',
        'slug',
        'hotel_code',

        'star_rating',

        'phone',
        'email',
        'website',

        'address',

        'short_description',
        'description',

        'featured_image',

        'check_in_time',
        'check_out_time',

        'latitude',
        'longitude',

        'starting_price',

        'rating',
        'reviews_count',

        'featured',
        'popular',
        'status',

        'sort_order',

        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'starting_price'=>'decimal:2',

        'rating'=>'decimal:2',

        'featured'=>'boolean',

        'popular'=>'boolean',

        'status'=>'boolean',

    ];

    // -------------------------------- Relationships -------------------------------- //

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function images()
    {
        return $this->hasMany(HotelImage::class)
            ->orderBy('sort_order');
    }

    public function featuredImage()
    {
        return $this->hasOne(HotelImage::class)
            ->where('is_featured', true);
    }

    public function rooms()
    {
        return $this->hasMany(HotelRoom::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(
            HotelAmenity::class,
            'hotel_amenity_hotel',
            'hotel_id',
            'hotel_amenity_id'
        )->withTimestamps();
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

    // ------------ Future Modules ------------ //
    public function reviews()
    {
        return $this->morphMany(
            Review::class,
            'reviewable'
        );
    }

    // public function bookings()
    // {
    //     return $this->hasMany(HotelBooking::class);
    // }
}
