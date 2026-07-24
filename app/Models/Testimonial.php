<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'country_id',
        'state_id',
        'city_id',
        'name',
        'designation',
        'company',
        'image',
        'rating',
        'review',
        'featured',
        'status',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'rating' => 'integer',
        'featured' => 'boolean',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    // ------------------ Query Scopes ------------------ //
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // ------------------ Accessors ------------------ //
    public function getImageAttribute()
    {
        if(
            $this->attributes['image'] &&
            file_exists(public_path('images/testimonials/'.$this->attributes['image']))
        ){
            return asset('images/testimonials/'.$this->attributes['image']);
        }
        return asset('admin/assets/img/avatars/1.png');
    }

    // ------------------ Relationship ------------------ //
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
}
