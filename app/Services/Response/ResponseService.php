<?php

namespace App\Services\Response;

class ResponseService
{
    /**
     * [200] Build success response
     */
    public function success(string $message = '', mixed $payload = [], int $status = 200): \Illuminate\Http\JsonResponse
    {
        return $this->build(true, $status, $message, $payload);
    }

    /**
     * [429] Build error response
     */
    public function error(string $message = '', mixed $payload = [], int $status = 400): \Illuminate\Http\JsonResponse
    {
        return $this->build(false, $status, $message, $payload);
    }

    /**
     * Build response
     */
    public function build(bool $success, int $code, string $message = '', mixed $payload = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'payload' => $payload
        ], $code);
    }
}

