<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarFeatureCar extends Model
{
    public function cars()
    {
        return $this->belongsToMany(
            Car::class,
            'car_feature_car',
            'car_feature_id',
            'car_id'
        )->withTimestamps();
    }
}
