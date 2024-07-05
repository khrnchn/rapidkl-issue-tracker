<?php

namespace App\Enums;

class CategoryEnum
{
    const BREAKDOWN = 1;
    const DELAY = 2;
    const SERVICE_DISRUPTION = 3;

    public static function toArray()
    {
        return [
            'BREAKDOWN' => self::BREAKDOWN,
            'DELAY' => self::DELAY,
            'SERVICE_DISRUPTION' => self::SERVICE_DISRUPTION,
        ];
    }
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::BREAKDOWN:
                return ucfirst(strtolower('BREAKDOWN')); // Capitalize first letter
            case self::DELAY:
                return ucfirst(strtolower('DELAY')); // Capitalize first letter
            case self::SERVICE_DISRUPTION:
                return ucfirst(strtolower('SERVICE DISRUPTION')); // Capitalize first letter
            default:
                return '';
        }
    }
}
