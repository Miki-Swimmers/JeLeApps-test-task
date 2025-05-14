<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест: регистрация - успех
     */
    public function test_successful_register(): void
    {
        $response = $this->postJson(route('api.v1.auth.register'), [
            'email' => 'test@test.com',
            'password' => 'password',
            'gender' => 'MALE'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'payload' => [
                    'access_token',
                    'refresh_token'
                ]
            ]);
    }

    /**
     * Тест: авторизация - успех
     */
    public function test_successful_login(): void
    {
        /**
         * Регистрируем пользователя
         */
        $response = $this->postJson(route('api.v1.auth.register'), [
            'email' => 'test@test.com',
            'password' => 'password',
            'gender' => 'MALE'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'payload' => [
                    'access_token',
                    'refresh_token'
                ]
            ]);

        /**
         * Пробуем пройти авторизацию за нового пользователя
         */
        $response = $this->postJson(route('api.v1.auth.login'), [
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'payload' => [
                    'access_token',
                    'refresh_token'
                ]
            ]);
    }
}
