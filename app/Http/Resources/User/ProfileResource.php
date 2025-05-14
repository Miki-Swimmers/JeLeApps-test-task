<?php

namespace App\Http\Resources\User;

use App\Enums\Gender;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
             * Имя пользователя
             */
            'name' => $this->resource->name,
            /**
             * E-Mail
             */
            'email' => $this->resource->email,
            /**
             * Пол
             *
             * @var Gender
             */
            'gender' => $this->resource->gender
        ];
    }
}
