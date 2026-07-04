<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'destination_id',
        'car_category_id',
        'name',
        'slug',
        'car_code',
        'brand',
        'model',
        'year',
        'color',
        'transmission',
        'fuel_type',
        'engine_capacity',
        'seats',
        'doors',
        'bags',
        'air_conditioning',
        'registration_no',
        'license_plate',
        'short_description',
        'description',
        'pickup_location',
        'dropoff_location',
        'latitude',
        'longitude',
        'base_price_per_day',
        'security_deposit',
        'insurance_included',
        'free_cancellation',
        'instant_booking',
        'minimum_driver_age',
        'fuel_policy',
        'mileage_limit',
        'rating',
        'reviews_count',
        'featured',
        'availability',
        'status',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'base_price_per_day' => 'decimal:2',
        'security_deposit' => 'decimal:2',
        'rating' => 'decimal:2',
        'air_conditioning' => 'boolean',
        'insurance_included' => 'boolean',
        'free_cancellation' => 'boolean',
        'instant_booking' => 'boolean',
        'featured' => 'boolean',
        'availability' => 'boolean',
        'status' => 'boolean',
    ];

    // ------------------------------------- Relationships ------------------------------------- //

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function category()
    {
        return $this->belongsTo(CarCategory::class,'car_category_id');
    }

    public function images()
    {
        return $this->hasMany(CarImage::class)
            ->orderBy('sort_order');
    }

    public function featuredImage()
    {
        return $this->hasOne(CarImage::class)
            ->where('is_featured', true);
    }

    public function features()
    {
        return $this->belongsToMany(
            CarFeature::class,
            'car_feature_car',
            'car_id',
            'car_feature_id'
        )->withTimestamps();
    }

    public function prices()
    {
        return $this->hasMany(CarPrice::class);
    }

    public function currentPrice()
    {
        return $this->hasOne(CarPrice::class)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->orderBy('priority');
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

    // ------------------------------------- Scopes ------------------------------------- //

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('availability', true);
    }

    // ------------------------------------- Accessors ------------------------------------- //

    public function getCurrentPriceAttribute()
    {
        return $this->base_price_per_day;
    }
}
