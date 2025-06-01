<?php

namespace App\Services;

use App\DTOs\NotificationInDTO;
use App\DTOs\NotificationOutDTO;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use DomainException;

class NotificationService
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository
    ) {
        $this->notificationRepository = $notificationRepository;
    }

    public function create(NotificationInDTO $request): NotificationOutDTO
    {
        $notification = $this->notificationRepository->create($request);

        return new NotificationOutDTO(
            $notification['id'],
            $notification['alert_id'],
            $notification['sent_at'],
            $notification['channel'],
            $notification['message'],
            $notification['status']
        );
    }

    public function findByid(string $id): NotificationOutDTO
    {
        $notification = $this->notificationRepository->findById($id);

        if (!$notification) {
            throw new DomainException('Notification not found', 404);
        }

        return new NotificationOutDTO(
            $notification['id'],
            $notification['alert_id'],
            $notification['sent_at'],
            $notification['channel'],
            $notification['message'],
            $notification['status']
        );
    }

    public function findByAlert(string $alertId): array
    {
        return $this->notificationRepository->findByAlert($alertId);
    }
}
