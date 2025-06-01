<?php

namespace App\Repositories\Interfaces;

use App\DTOs\UserInDTO;

interface UserRepositoryInterface
{
    public function findById(string $id): array;

    public function create(UserInDTO $data): array;

    public function registerPassword(string $id, string $pass): bool;

    public function validEmailExists(string $email): bool;

    public function findAll(): array;

    public function update(string $id, UserInDTO $request): bool;
}
