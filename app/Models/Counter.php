<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'icon',
        'title',
        'number',
        'prefix',
        'suffix',
        'description',
        'sort_order',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
