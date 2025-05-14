<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    /**
     * Пройти авторизацию по данным
     *
     * @param array $credentials
     * @return ?array{
     *     access_token: string,
     *     refresh_token: string
     * }
     */
    public function auth(array $credentials): ?array
    {
        if (! $accessToken = Auth::attempt($credentials)) {
            return null;
        }

        /** @var User $user */
        $user = Auth::user();

        $refreshToken = JWTAuth::customClaims(['refresh' => true])->fromUser($user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];
    }

    /**
     * Зарегистрировать пользователя
     */
    public function register(array $data): ?array
    {
        User::query()->create($data);

        return $this->auth($data);
    }

    /**
     * Обновить токен
     */
    public function refreshToken(?string $refreshToken): ?array
    {
        if (! $refreshToken) {
            return null;
        }

        try {
            $payload = JWTAuth::setToken($refreshToken)->getPayload();
        } catch (\Throwable $e) {
            return null;
        }

        if (! $payload->get('refresh')) {
            return null;
        }

        $user = JWTAuth::setToken($refreshToken)->toUser();

        return [
            'access_token' => JWTAuth::fromUser($user),
            'refresh_token' => JWTAuth::customClaims(['refresh' => true])->fromUser($user),
        ];
    }
}
