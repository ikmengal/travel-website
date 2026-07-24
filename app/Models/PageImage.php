<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'page_id',
        'image',
        'title',
        'caption',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getImageUrlAttribute()
    {
        if (
            $this->image &&
            file_exists(public_path('images/pages/gallery/' . $this->image))
        ) {
            return asset('images/pages/gallery/' . $this->image);
        }

        return asset('admin/assets/img/placeholder.jpg');
    }
}
