<?php

namespace App\Repositories\Interfaces;

use App\DTOs\NotificationInDTO;

interface NotificationRepositoryInterface
{
    public function create(NotificationInDTO $data): array;

    public function findById(string $id): array;

    public function findByAlert(string $alertId): array;

    public function delete(string $id): bool;
}
