<?php

namespace App\Repositories\Eloquent;

use App\DTOs\AlertInDTO;
use App\Models\Alert;
use App\Repositories\Interfaces\AlertRepositoryInterface;

class AlertRepository implements AlertRepositoryInterface
{
    public function findActive(): array
    {
        $alert = Alert::where('is_active', true)->get();

        if (!$alert) {
            return [];
        }

        return $alert->toArray();
    }

    public function findById(string $id): array
    {
        $alert = Alert::where('id', $id)->first();

        if (!$alert) {
            return [];
        }

        return $alert->toArray();
    }

    public function create(AlertInDTO $data): array
    {
        return Alert::create([
            'user_id' => $data->userId,
            'symbol' => $data->symbol,
            'condition' => $data->condition,
            'value' => $data->value,
            'currency' => $data->currency,
            'is_active' => $data->isActive
        ])->toArray();
    }

    public function update(string $id, AlertInDTO $data): bool
    {
        return Alert::where('id', $id)->update([
                'condition' => $data->condition,
                'value' => $data->value,
                'currency' => $data->currency,
                'is_active' => $data->isActive
            ]);
    }

    public function findByUser(string $userId): array
    {
        $alert = Alert::where('user_id', $userId)->get();

        if (!$alert) {
            return [];
        }

        return $alert->toArray();
    }
}
