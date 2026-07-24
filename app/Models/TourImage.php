<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    // ----------------- Accessor ----------------- //
    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path('images/tours/'.$value))) {
            return asset('images/tours/'.$value);
        }
        return asset('images/destinations/hero.jpg');
    }
}
