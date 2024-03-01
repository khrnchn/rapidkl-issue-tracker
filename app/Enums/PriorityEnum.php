<?php

namespace App\Enums;

class PriorityEnum
{
    const LOW = 1;
    const MEDIUM = 2;
    const HIGH = 3;

    public static function toArray()
    {
        return [
            'LOW' => self::LOW,
            'MEDIUM' => self::MEDIUM,
            'HIGH' => self::HIGH,
        ];
    }
}
