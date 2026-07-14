<?php

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
                return '<span class="badge bg-label-success">
                            Active
                        </span>';

            case '0':
            case 'inactive':
            case 'false':
                return '<span class="badge bg-label-danger">
                            Inactive
                        </span>';

            case 'pending':
                return '<span class="badge bg-label-warning">
                            Pending
                        </span>';

            default:
                return '<span class="badge bg-label-secondary">
                            '.ucfirst($status).'
                        </span>';
        }
    }
}
