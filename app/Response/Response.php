<?php

namespace App\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response as Resp;

class Response
{
    protected static $data = [];
    protected static string $message = '';
    protected static int $status = HttpResponse::HTTP_OK;

    protected static function return(): array
    {
        return [
            'data' => self::$data,
            'message' => self::$message,
            'status' => self::$status
        ];
    }

    public static function json($data, $message, $status = HttpResponse::HTTP_OK): JsonResponse
    {
        self::$data = $data;
        self::$message = $message;
        self::$status = $status;
        return Resp::json(self::return(), $status);
    }

    public static function jsonError(\Throwable $e, int $status = HttpResponse::HTTP_BAD_REQUEST): JsonResponse
    {
        self::$message = $e->getMessage();
        self::$status = $status;

        self::verifyException($e);

        return Resp::json(self::return(), self::$status);
    }

    protected static function verifyException(\Throwable $e): void
    {
        if (!$e instanceof \DomainException) {
            self::$message = 'Failed to process your request. Please try again later.';
            self::$status = HttpResponse::HTTP_INTERNAL_SERVER_ERROR;
        }
    }
}
