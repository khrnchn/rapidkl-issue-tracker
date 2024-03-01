<?php

namespace App\Enums;

class StatusEnum
{
    const REPORTED = 1;
    const IN_PROGRESS = 2;
    const RESOLVED = 3;

    public static function toArray()
    {
        return [
            'REPORTED' => self::REPORTED,
            'IN_PROGRESS' => self::IN_PROGRESS,
            'RESOLVED' => self::RESOLVED,
        ];
    }
}
