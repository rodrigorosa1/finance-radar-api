<?php

namespace App\Repositories\Eloquent;

use App\DTOs\UserInDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function findById(string $id): array
    {
        $user =  User::where('id', $id)->first();

        if (!$user) {
            return [];
        }

        return $user->toArray();
    }

    public function create(UserInDTO $data): array
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password,
            'phone' => $data->phone,
            'type_notification' => $data->typeNotification,
        ])->toArray();
    }

    public function registerPassword(string $id, string $pass): bool
    {
        return User::where('id', $id)->update([
            'password' => Hash::make($pass),
            'first_access' => true,
        ]);
    }

    public function validEmailExists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    public function findAll(): array
    {
        return User::get()->toArray();
    }

    public function update(string $id, UserInDTO $data): bool
    {
        return User::where('id', $id)->update([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password,
            'phone' => $data->phone,
            'type_notification' => $data->typeNotification,
        ]);
    }
}
