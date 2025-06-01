<?php

namespace App\DTOs;

class AlertInDTO
{
    public string $userId;
    public string $symbol;
    public string $condition;
    public string $value;
    public string $currency;
    public bool $isActive;

    public function __construct(
        string $userId,
        string $symbol,
        string $condition,
        string $value,
        string $currency,
        bool $isActive
    ) {
        $this->userId = $userId;
        $this->symbol = $symbol;
        $this->condition = $condition;
        $this->value = $value;
        $this->currency = $currency;
        $this->isActive = $isActive;
    }
}
