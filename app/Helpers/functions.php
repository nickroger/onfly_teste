<?php

use App\Enums\OrderStatus;

if (!function_exists('getStatusOrder')) {
    function getStatusOrder(string $status): string
    {
        return OrderStatus::fromValue($status);
    }
}
