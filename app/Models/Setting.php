<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'autoload',
        'status',
    ];

    protected $casts = [
        'autoload' => 'boolean',
        'status' => 'boolean',
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

    public function scopeAutoload($query)
    {
        return $query->where('autoload', true);
    }

    public function scopeGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public static function get($key, $default = null)
    {
        return cache()->rememberForever("setting.$key", function () use ($key, $default) {

            return static::where('key', $key)
                ->where('status', true)
                ->value('value') ?? $default;

        });
    }

    public static function set($key, $value)
    {
        static::updateOrCreate(

            ['key' => $key],

            ['value' => $value]

        );

        cache()->forget("setting.$key");
    }
}
