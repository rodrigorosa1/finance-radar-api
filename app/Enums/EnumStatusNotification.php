<?php

namespace App\Enums;

class EnumStatusNotification
{
    const SENDER = 1;
    const ERROR = 2;

    const STATUS = [
        self::SENDER => 'SENDER',
        self::ERROR => 'ERROR',
    ];
}
