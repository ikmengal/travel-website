<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Airline extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'iata_code',
        'icao_code',
        'airline_code',
        'logo',
        'website',
        'phone',
        'email',
        'description',
        'featured',
        'status',
        'sort_order',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'featured'=>'boolean',
        'status'=>'boolean',
    ];

    // ---------------- Relationships ---------------- //
    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    // ---------------- Scopes ---------------- //
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
        return $query
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    // ---------------- Accessor ---------------- //
    public function getLogoUrlAttribute()
    {
        if ($this->logo && file_exists(public_path('images/airlines/' . $this->logo))) {
            return asset('images/airlines/' . $this->logo);
        }
        return asset('admin/assets/img/placeholder.jpg');
    }
}
