<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * Основной токен авторизации
             */
            'access_token' => $this->resource['access_token'],
            /**
             * Токен для обновления accessToken'а
             */
            'refresh_token' => $this->resource['refresh_token']
        ];
    }
}
