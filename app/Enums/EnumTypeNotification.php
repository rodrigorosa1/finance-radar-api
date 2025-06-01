<?php

namespace App\Enums;

class EnumTypeNotification
{
    const WATTSAPP = 1;
    const EMAIL = 2;
    const TELEGRAN = 2;

    const STATUS = [
        self::WATTSAPP => 'WATTSAPP',
        self::EMAIL => 'EMAIL',
        self::TELEGRAN => 'TELEGRAN',
    ];
}
