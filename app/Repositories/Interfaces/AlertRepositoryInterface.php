<?php

namespace App\Repositories\Interfaces;

use App\DTOs\AlertInDTO;

interface AlertRepositoryInterface
{
    public function findActive(): array;

    public function findById(string $id): array;

    public function create(AlertInDTO $data): array;

    public function update(string $id, AlertInDTO $data): bool;

    public function findByUser(string $userId): array;
}
