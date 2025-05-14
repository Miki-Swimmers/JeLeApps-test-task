<?php

namespace app\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * AuthController constructor
     */
    public function __construct(
        private readonly AuthService $authService
    )
    {
    }

    /**
     * Авторизация.
     *
     * Используется двухуровневая авторизация:
     * - Access Token — передаётся в заголовке Authorization, живёт 15 минут;
     * - Refresh Token — устанавливается как HttpOnly cookie, живёт 30 дней.
     *
     * @unauthenticated
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $access = $this->authService->auth([
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);

        if (! $access) {
            abort(401, 'Неверные учётные данные');
        }

        /**
         * @status 200
         * @body array{success: true, message: 'Успех!', payload: AuthResource}
         */
        return $this->response()
            ->success('Успех!', AuthResource::make($access))
            ->withCookie(cookie(
                'refresh_token',
                $access['refresh_token'],
                43200,
                '/',
                null,
                true,
                true,
                false,
                'Strict'
            ));
    }


    /**
     * Регистрация
     */
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $access = $this->authService->register([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'gender' => $request->get('gender')
        ]);

        if (! $access) {
            abort(401, 'Неверные учётные данные');
        }

        /**
         * @status 200
         * @body array{success: true, message: 'Успех!', payload: AuthResource}
         */
        return $this->response()
            ->success('Успех!', AuthResource::make($access))
            ->withCookie(cookie(
                'refresh_token',
                $access['refresh_token'],
                43200,
                '/',
                null,
                true,
                true,
                false,
                'Strict'
            ));
    }

    /**
     * Обновление токена.
     *
     * Возвращает новый Access Token и Refresh Token.
     *
     * @unauthenticated
     */
    public function refresh(Request $request): \Illuminate\Http\JsonResponse
    {
        $access = $this->authService->refreshToken($request->cookie('refresh_token'));

        if (! $access) {
            abort(419, 'Недействительный refresh токен');
        }

        /**
         * @status 200
         * @body array{success: true, message: 'Успех!', payload: AuthResource}
         */
        return $this->response()
            ->success('Успех!', AuthResource::make($access))
            ->withCookie(cookie(
                'refresh_token',
                $access['refresh_token'],
                43200,
                '/',
                null,
                true,
                true,
                false,
                'Strict'
            ));
    }
}
