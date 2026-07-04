<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_popular' => 'boolean',
        'status' => 'boolean',
    ];

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

    public function images()
    {
        return $this->hasMany(DestinationImage::class)
            ->orderBy('sort_order');
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
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
