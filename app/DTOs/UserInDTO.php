<?php

namespace App\DTOs;

class UserInDTO
{
    public string $name;
    public string $email;
    public string $password;
    public string $phone;
    public int $typeNotification;

    public function __construct(
        string $name,
        string $email,
        string $password,
        string $phone,
        int $typeNotification
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->typeNotification = $typeNotification;
    }
}
