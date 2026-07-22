<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'image',
        'caption',
        'description',
        'sort_order',
        'featured',
        'status',
    ];

    protected $casts = [
        'featured'=>'boolean',
        'status'=>'boolean',
    ];

    // ----------------- Scopes ----------------- //
    public function scopeActive($query)
    {
        return $query->where('status',true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured',true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    // ----------------- Accessor ----------------- //
    public function getImageAttribute()
    {
        if(
            $this->attributes['image'] &&
            file_exists(public_path('images/gallery/'.$this->attributes['image']))
        ){
            return asset('images/gallery/'.$this->attributes['image']);
        }
        return asset('admin/assets/img/avatars/1.png');
    }
}
