<?php

namespace App\DTOs;

class UserOutDTO
{
    public string $id;
    public string $name;
    public string $email;
    public string $phone;
    public int $typeNotification;

    public function __construct(
        string $id,
        string $name,
        string $email,
        string $phone,
        int $typeNotification
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->typeNotification = $typeNotification;
    }
}
