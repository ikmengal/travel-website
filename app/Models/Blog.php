<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'blog_category_id',

        'title',

        'slug',

        'short_description',

        'description',

        'featured_image',

        'author',

        'published_at',

        'views',

        'featured',

        'status',

        'meta_title',

        'meta_description',

    ];

    protected $casts = [

        'published_at' => 'datetime',

        'featured' => 'boolean',

        'status' => 'boolean',

        'views' => 'integer',

    ];


    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image
            ? asset('images/blogs' . $this->featured_image)
            : asset('admin/assets/img/avatars/1.png');
    }

    //----------------- Relationships ----------------- //
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    /**
     * Blog Comments
     */
    public function comments()
    {
        return $this->hasMany(BlogComment::class)
            ->orderBy('sort_order')
            ->orderBy('created_at');
    }

    /**
     * Tags
     */
    public function tags()
    {
        return $this->belongsToMany(
            BlogTag::class,
            'blog_blog_tags',
            'blog_id',
            'blog_tag_id'
        )->withTimestamps();
    }
}
