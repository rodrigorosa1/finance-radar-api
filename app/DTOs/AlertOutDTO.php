<?php

namespace App\DTOs;

class AlertOutDTO
{
    public string $id;
    public string $userId;
    public string $symbol;
    public string $condition;
    public float $value;
    public string $currency;
    public bool $isActive;


    public function __construct(
        string $id,
        string $userId,
        string $symbol,
        string $condition,
        float $value,
        string $currency,
        bool $isActive
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->symbol = $symbol;
        $this->condition = $condition;
        $this->value = $value;
        $this->currency = $currency;
        $this->isActive = $isActive;
    }
}
