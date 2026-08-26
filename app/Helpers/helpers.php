<?php

use App\Models\Setting;

function Setting(){
    $setting = Setting::first();
    if(isset($setting) && !empty($setting)){
        return $setting;
    }else{
        return $setting = [
            'site_name' => env('APP_NAME'),
            'site_tagline' => env('APP_NAME', 'Explore The World With Us'),
            'site_email' => env('APP_NAME', 'admin@travelbooking.com'),
            'site_phone' => env('APP_NAME', '+92-300-1234567'),
            'site_address' => env('APP_NAME', 'Karachi, Pakistan'),
        ];
    }
}

if (!function_exists('bookingStatusBadge')) {
    function bookingStatusBadge($status)
    {
        return match ($status) {
            'pending' => '<span class="badge bg-label-warning">Pending</span>',

            'confirmed' => '<span class="badge bg-label-success">Confirmed</span>',

            'completed' => '<span class="badge bg-label-primary">Completed</span>',

            'cancelled' => '<span class="badge bg-label-danger">Cancelled</span>',

            'refunded' => '<span class="badge bg-label-dark">Refunded</span>',

            default => '<span class="badge bg-label-secondary">Unknown</span>',
        };
    }
}

if (!function_exists('paymentStatusBadge')) {
    function paymentStatusBadge($status)
    {
        return match ($status) {

            'pending' => '<span class="badge bg-label-warning">Pending</span>',

            'paid' => '<span class="badge bg-label-success">Paid</span>',

            'failed' => '<span class="badge bg-label-danger">Failed</span>',

            'refunded' => '<span class="badge bg-label-info">Refunded</span>',

            'cancelled' => '<span class="badge bg-label-secondary">Cancelled</span>',

            default => '<span class="badge bg-label-secondary">Unknown</span>',
        };
    }
}

if (!function_exists('statusBadge')) {
    function statusBadge($status)
    {
        switch (strtolower((string) $status)) {

            case '1':
            case 'active':
            case 'true':
                return '<span class="badge bg-label-success">Active</span>';
            case '0':
            case 'inactive':
            case 'false':
                return '<span class="badge bg-label-danger">Inactive</span>';
            case 'pending':
                return '<span class="badge bg-label-warning">Pending</span>';
            default:
                return '<span class="badge bg-label-secondary">'.ucfirst($status).'</span>';
        }
    }
}

if (!function_exists('paymentMethodBadge')) {
    function paymentMethodBadge($method)
    {
        return match ($method) {
            'cash' => '<span class="badge bg-label-success">Cash</span>',

            'bank_transfer' => '<span class="badge bg-label-primary">Bank Transfer</span>',

            'credit_card' => '<span class="badge bg-label-info">Credit Card</span>',

            'debit_card' => '<span class="badge bg-label-secondary">Debit Card</span>',

            'paypal' => '<span class="badge bg-label-warning">PayPal</span>',

            'stripe' => '<span class="badge bg-label-dark">Stripe</span>',

            'jazzcash' => '<span class="badge bg-label-danger">JazzCash</span>',

            'easypaisa' => '<span class="badge bg-label-success">EasyPaisa</span>',

            default => '<span class="badge bg-label-dark">' . ucfirst($method) . '</span>',
        };
    }
}

if (!function_exists('couponTypeBadge')) {
    function couponTypeBadge($type)
    {
        return match ($type) {
            'fixed' => '<span class="badge bg-label-primary">Fixed</span>',
            'percentage' => '<span class="badge bg-label-success">Percentage</span>',
            default => '<span class="badge bg-label-secondary">N/A</span>',
        };
    }
}

if (!function_exists('readBadge')) {
    function readBadge($status)
    {
        return $status
            ? '<span class="badge bg-label-success">Read</span>'
            : '<span class="badge bg-label-warning">Unread</span>';
    }
}

if (!function_exists('replyBadge')) {
    function replyBadge($status)
    {
        return $status
            ? '<span class="badge bg-label-info">Replied</span>'
            : '<span class="badge bg-label-secondary">Pending</span>';
    }
}

if (!function_exists('messageStatusBadge')) {
    function messageStatusBadge($status)
    {
        switch (strtolower((string) $status)) {
            case 'new':
                return '<span class="badge bg-label-info">New</span>';
            case 'in_progress':
                return '<span class="badge bg-label-primary">In Progress</span>';
            case 'resolved':
                return '<span class="badge bg-label-success">Resolved</span>';
            case 'closed':
                return '<span class="badge bg-label-danger">Closed</span>';
            default:
                return '<span class="badge bg-label-secondary">'.ucfirst($status).'</span>';
        }
    }
}
