<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
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

    // --------------------- Available groups (used in dropdowns / tabs) --------------------- //
    public static array $groups = [
        'general' => 'General',
        'smtp'    => 'SMTP',
        'payment' => 'Payment',
        'seo'     => 'SEO',
        'social'  => 'Social',
    ];

    // --------------------- Available field types (used in dropdowns) --------------------- //
    public static array $types = [
        'text'     => 'Text',
        'textarea' => 'Textarea',
        'number'   => 'Number',
        'email'    => 'Email',
        'url'      => 'URL',
        'image'    => 'Image',
        'boolean'  => 'Boolean',
        'json'     => 'JSON',
        'password' => 'Password',
    ];

    // --------------------- Clear cache whenever a setting is saved or deleted --------------------- //
    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('app_settings'));
        static::deleted(fn () => Cache::forget('app_settings'));
    }

    // --------------------- Get a setting value by key (cached). --------------------- //
    public static function get(string $key, $default = null)
    {
        $settings = Cache::rememberForever('app_settings', function () {
            return self::where('status', true)->pluck('value', 'key')->all();
        });

        if (!is_array($settings)) {
            $settings = self::where('status', true)->pluck('value', 'key')->all();
        }

        return $settings[$key] ?? $default;
    }

    // --------------------- Set (create or update) a setting value by key. --------------------- //
    public static function set(string $key, $value): self
    {
        $setting = self::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $setting->save();

        return $setting;
    }

    // --------------------- Scopes --------------------- //
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

    // --------------------- Helper Methods --------------------- //
    // public static function get($key, $default = null)
    // {
    //     return cache()->rememberForever("setting.$key", function () use ($key, $default) {
    //         return static::where('key', $key)
    //             ->where('status', true)
    //             ->value('value') ?? $default;
    //     });
    // }

    // public static function set($key, $value)
    // {
    //     static::updateOrCreate(
    //         ['key' => $key],
    //         ['value' => $value]
    //     );
    //     cache()->forget("setting.$key");
    // }
}
