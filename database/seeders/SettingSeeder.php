<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $settings = [

         /*
            |--------------------------------------------------------------------------
            | General
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'general',
                'key' => 'site_name',
                'value' => 'Travel Booking',
                'type' => 'text',
            ],
            [
                'group' => 'general',
                'key' => 'site_tagline',
                'value' => 'Explore The World With Us',
                'type' => 'text',
            ],
            [
                'group' => 'general',
                'key' => 'site_email',
                'value' => 'admin@travelbooking.com',
                'type' => 'email',
            ],
            [
                'group' => 'general',
                'key' => 'site_phone',
                'value' => '+92-300-1234567',
                'type' => 'text',
            ],
            [
                'group' => 'general',
                'key' => 'site_address',
                'value' => 'Karachi, Pakistan',
                'type' => 'textarea',
            ],
            [
                'group' => 'general',
                'key' => 'logo',
                'value' => '',
                'type' => 'image',
            ],
            [
                'group' => 'general',
                'key' => 'favicon',
                'value' => '',
                'type' => 'image',
            ],

            /*
            |--------------------------------------------------------------------------
            | Booking
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'booking',
                'key' => 'default_currency',
                'value' => 'PKR',
                'type' => 'text',
            ],
            [
                'group' => 'booking',
                'key' => 'currency_symbol',
                'value' => 'Rs',
                'type' => 'text',
            ],
            [
                'group' => 'booking',
                'key' => 'timezone',
                'value' => 'Asia/Karachi',
                'type' => 'text',
            ],
            [
                'group' => 'booking',
                'key' => 'booking_tax',
                'value' => '5',
                'type' => 'number',
            ],

            /*
            |--------------------------------------------------------------------------
            | SMTP
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'smtp',
                'key' => 'mail_host',
                'value' => '',
                'type' => 'text',
            ],
            [
                'group' => 'smtp',
                'key' => 'mail_port',
                'value' => '587',
                'type' => 'number',
            ],
            [
                'group' => 'smtp',
                'key' => 'mail_username',
                'value' => '',
                'type' => 'text',
            ],
            [
                'group' => 'smtp',
                'key' => 'mail_password',
                'value' => '',
                'type' => 'password',
            ],
            [
                'group' => 'smtp',
                'key' => 'mail_encryption',
                'value' => 'tls',
                'type' => 'text',
            ],

            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'payment',
                'key' => 'stripe_key',
                'value' => '',
                'type' => 'text',
            ],
            [
                'group' => 'payment',
                'key' => 'stripe_secret',
                'value' => '',
                'type' => 'password',
            ],
            [
                'group' => 'payment',
                'key' => 'paypal_client_id',
                'value' => '',
                'type' => 'text',
            ],
            [
                'group' => 'payment',
                'key' => 'paypal_secret',
                'value' => '',
                'type' => 'password',
            ],

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'seo',
                'key' => 'meta_title',
                'value' => 'Travel Booking',
                'type' => 'text',
            ],
            [
                'group' => 'seo',
                'key' => 'meta_description',
                'value' => 'Best Travel Booking Platform',
                'type' => 'textarea',
            ],
            [
                'group' => 'seo',
                'key' => 'meta_keywords',
                'value' => 'travel,tours,hotel,flight,booking',
                'type' => 'textarea',
            ],

            /*
            |--------------------------------------------------------------------------
            | API Keys
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'api',
                'key' => 'google_maps_api_key',
                'value' => '',
                'type' => 'text',
            ],
            [
                'group' => 'api',
                'key' => 'google_recaptcha_site_key',
                'value' => '',
                'type' => 'text',
            ],
            [
                'group' => 'api',
                'key' => 'google_recaptcha_secret_key',
                'value' => '',
                'type' => 'password',
            ],

            /*
            |--------------------------------------------------------------------------
            | Maintenance
            |--------------------------------------------------------------------------
            */
            [
                'group' => 'system',
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
            ],
            [
                'group' => 'system',
                'key' => 'registration_enabled',
                'value' => '1',
                'type' => 'boolean',
            ],
            [
                'group' => 'system',
                'key' => 'email_verification',
                'value' => '1',
                'type' => 'boolean',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                [
                    'key' => $setting['key']
                ],
                [
                    'group' => $setting['group'],
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'autoload' => true,
                    'status' => true,
                ]
            );
        }
    }
}
