<?php

namespace App\Enums;

enum OrderStatus: string
{
    case r = "Requested";
    case a = "Aproved";
    case c = "Canceled";


    public static function fromValue(string $name): string
    {
        foreach (self::cases() as $status) {
            if ($name === $status->name) {
                return $status->value;
            }
        }

        throw new \ValueError("$status is not a valid");
    }
}
