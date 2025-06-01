<?php

namespace App\Services;

use App\DTOs\UserInDTO;
use App\DTOs\UserOutDTO;
use App\Repositories\Interfaces\UserRepositoryInterface;
use DomainException;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function register(UserInDTO $request): UserOutDTO
    {
        if ($this->userRepository->validEmailExists($request->email)) {
            throw new DomainException('Email already registered', 405);
        }

        $user = $this->userRepository->create($request);

        return new UserOutDTO(
            $user['id'],
            $user['name'],
            $user['email'],
            $user['phone'],
            $user['type_notification']
        );
    }

    public function findById(string $id): UserOutDTO
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new DomainException('User not found', 404);
        }

        return new UserOutDTO(
            $user['id'],
            $user['name'],
            $user['email'],
            $user['phone'],
            $user['type_notification']
        );
    }

    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }

    public function update(string $id, UserInDTO $request): bool
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new DomainException('User not found', 404);
        }

        return $this->userRepository->update($id, $request);
    }
}
