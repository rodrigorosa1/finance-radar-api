<?php

namespace App\DTOs;

use DateTime;

class NotificationInDTO
{
    public string $alertId;
    public DateTime $sentAt;
    public string $channel;
    public string $message;

    public function __construct(string $alertId, DateTime $sentAt, string $channel, string $message)
    {
        $this->alertId = $alertId;
        $this->sentAt = $sentAt;
        $this->channel = $channel;
        $this->message = $message;
    }
}
