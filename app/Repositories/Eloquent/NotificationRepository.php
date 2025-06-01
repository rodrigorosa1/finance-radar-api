<?php

namespace App\Repositories\Eloquent;

use App\DTOs\NotificationInDTO;
use App\Enums\EnumStatusNotification;
use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function create(NotificationInDTO $data): array
    {
        return Notification::create([
            'alert_id' => $data->alertId,
            'sent_at' => $data->sentAt,
            'channel' => $data->channel,
            'message' => $data->message,
            'status' => EnumStatusNotification::SENDER,
        ])->toArray();
    }

    public function findById(string $id): array
    {
        $notification = Notification::where('id', $id)->get();

        if (!$notification) {
            return [];
        }

        return $notification->toArray();
    }

    public function findByAlert(string $alertId): array
    {
        $notification = Notification::where('alert_id', $alertId)->get();

        if (!$notification) {
            return [];
        }

        return $notification->toArray();
    }

    public function delete(string $id): bool
    {
        return Notification::where('id', $id)->delete();
    }
}
