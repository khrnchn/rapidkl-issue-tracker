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
}
