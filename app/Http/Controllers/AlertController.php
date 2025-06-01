<?php

namespace App\Http\Controllers;

use App\DTOs\AlertInDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlertRequest;
use App\Response\Response;
use App\Services\AlertService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response as HttpResponse;

class AlertController extends Controller
{
    private AlertService $alertService;

    public function __construct(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }

    public function create(AlertRequest $request): JsonResponse
    {
        try {
            $alertDto = new AlertInDTO(
                $request->userId,
                $request->symbol,
                $request->condition,
                $request->value,
                $request->currency,
                true
            );
            DB::beginTransaction();
            $alert = $this->alertService->create($alertDto);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to register alert {$request->userId} - {$request->symbol}", [
                'payload' => $request->all(),
                'exception' => $e,
            ]);
            return Response::jsonError($e);
        }
        return Response::json($alert, 'Alert created', HttpResponse::HTTP_CREATED);
    }

    public function findById(string $id): JsonResponse
    {
        try {
            $alert = $this->alertService->findById($id);
        } catch (Exception $e) {
            Log::error("Failed to query alert {$id}", [
                'exception' => $e,
            ]);
            return Response::jsonError($e);
        }
        return Response::json($alert, 'Alert data');
    }

    public function findByUser(string $userId): JsonResponse
    {
        try {
            $alert = $this->alertService->findByUser($userId);
        } catch (Exception $e) {
            Log::error("Failed to query alert for user {$userId}", [
                'exception' => $e,
            ]);
            return Response::jsonError($e);
        }
        return Response::json($alert, 'Alert data');
    }

    public function update(string $id, AlertRequest $request): JsonResponse
    {
        try {
            $alertDto = new AlertInDTO(
                $request->userId,
                $request->symbol,
                $request->condition,
                $request->value,
                $request->currency,
                true
            );
            DB::beginTransaction();
            $alert = $this->alertService->update($id, $alertDto);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to updated alert {$id}", [
                'payload' => $request->all(),
                'exception' => $e,
            ]);
            return Response::jsonError($e);
        }
        return Response::json($alert, 'Alert updated');
    }
}
