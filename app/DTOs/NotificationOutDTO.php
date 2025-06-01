<?php

namespace App\DTOs;

class NotificationOutDTO
{
    public string $id;
    public string $alertid;
    public string $sentAt;
    public string $channel;
    public string $message;

    public function __construct(string $id, string $alertid, string $sentAt, string $channel, string $message)
    {
        $this->id = $id;
        $this->alertid = $alertid;
        $this->sentAt = $sentAt;
        $this->channel = $channel;
        $this->message = $message;
    }
}
