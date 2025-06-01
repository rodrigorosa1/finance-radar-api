<?php

namespace App\Http\Controllers;

use App\DTOs\UserInDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Response\Response;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response as HttpResponse;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRequest $request): JsonResponse
    {
        try {
            $userDto = new UserInDTO(
                $request->name,
                $request->email,
                $request->password,
                $request->phone,
                $request->typeNotification,
            );
            DB::beginTransaction();
            $user = $this->userService->register($userDto);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to register user {$request->email}", [
                'payload' => $request->all(),
                'exception' => $e,
            ]);
            return Response::jsonError($e);
        }
        return Response::json($user, 'User created', HttpResponse::HTTP_CREATED);
    }

    public function findById(string $id): JsonResponse
    {
        try {
            $user = $this->userService->findById($id);
        } catch (Exception $e) {
            Log::error("Failed to query user {$id}", [
                'exception' => $e,
            ]);
            return Response::jsonError($e);
        }
        return Response::json($user, 'User data');
    }

    public function findAll(): JsonResponse
    {
        try {
            $users = $this->userService->findAll();
        } catch (Exception $e) {
            Log::error("Failed to query user", [
                'exception' => $e,
            ]);
            return Response::jsonError($e);
        }
        return Response::json($users, 'Users data');
    }

    public function update(string $id, UserRequest $request): JsonResponse
    {
        try {
            $userDto = new UserInDTO(
                $request->name,
                $request->email,
                $request->password,
                $request->phone,
                $request->typeNotification,
            );
            DB::beginTransaction();
            $user = $this->userService->update($id, $userDto);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to update user {$request->id}", [
                'payload' => $request->all(),
                'exception' => $e,
            ]);
            return Response::jsonError($e);
        }
        return Response::json($user, 'User updated');
    }
}
