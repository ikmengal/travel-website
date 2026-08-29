<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'title' => 'Welcome 10% Off',
                'type' => 'percentage',
                'value' => 10,
                'minimum_amount' => 5000,
                'maximum_discount' => null,
                'usage_limit' => 100,
                'expires_in_days' => 90,
            ],
            [
                'code' => 'SAVE500',
                'title' => 'Save Rs. 500',
                'type' => 'fixed',
                'value' => 500,
                'minimum_amount' => 0,
                'maximum_discount' => null,
                'usage_limit' => 100,
                'expires_in_days' => 60,
            ],
            [
                'code' => 'SUMMER20',
                'title' => 'Summer Sale 20% Off',
                'type' => 'percentage',
                'value' => 20,
                'minimum_amount' => 0,
                'maximum_discount' => 20000,
                'usage_limit' => 200,
                'expires_in_days' => 45,
            ],
            [
                'code' => 'FLASH50',
                'title' => 'Flash Deal Rs. 50 Off',
                'type' => 'fixed',
                'value' => 50,
                'minimum_amount' => 0,
                'maximum_discount' => null,
                'usage_limit' => 500,
                'expires_in_days' => 15,
            ],
        ];

        foreach ($coupons as $item) {
            Coupon::updateOrCreate(
                ['code' => $item['code']],
                [
                    'code' => $item['code'],
                    'title' => $item['title'],
                    'type' => $item['type'],
                    'value' => $item['value'],
                    'minimum_amount' => $item['minimum_amount'],
                    'maximum_discount' => $item['maximum_discount'],
                    'usage_limit' => $item['usage_limit'],
                    'used' => 0,
                    'starts_at' => now()->subDays(1),
                    'expires_at' => now()->addDays($item['expires_in_days']),
                    'status' => true,
                ]
            );
        }
    }
}
