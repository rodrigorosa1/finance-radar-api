<?php

namespace App\Services;

use App\DTOs\AlertInDTO;
use App\DTOs\AlertOutDTO;
use App\Repositories\Interfaces\AlertRepositoryInterface;
use DomainException;

class AlertService
{
    private AlertRepositoryInterface $alertRepository;

    public function __construct(
        AlertRepositoryInterface $alertRepository
    ) {
        $this->alertRepository = $alertRepository;
    }

    public function create(AlertInDTO $request): AlertOutDTO
    {
        $alert = $this->alertRepository->create($request);

        return new AlertOutDTO(
            $alert['id'],
            $alert['userId'],
            $alert['symbol'],
            $alert['condition'],
            $alert['value'],
            $alert['currency'],
            $alert['isActive'],
        );
    }

    public function findActive(): array
    {
        return $this->alertRepository->findActive();
    }

    public function update(string $id, AlertInDTO $request): bool
    {
        $alert = $this->alertRepository->findById($id);

        if (!$alert) {
            throw new DomainException('Alert not found', 404);
        }

        return $this->alertRepository->update($id, $request);
    }

    public function findById(string $id): AlertOutDTO
    {
        $alert = $this->alertRepository->findById($id);

        if (!$alert) {
            throw new DomainException('Alert not found', 404);
        }

        return new AlertOutDTO(
            $alert['id'],
            $alert['userId'],
            $alert['symbol'],
            $alert['condition'],
            $alert['value'],
            $alert['currency'],
            $alert['isActive'],
        );
    }

    public function findByUser(string $userId): array
    {
        return $this->alertRepository->findByUser($userId);
    }
}
