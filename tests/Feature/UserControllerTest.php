<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест: регистрация - успех
     */
    public function test_successful_profile(): void
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

        $response = $this->getJson(
            route('api.v1.users.profile'),
            ['Authorization' => 'Bearer ' . $response->json('access_token')]
        );

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'payload' => [
                    'name',
                    'email',
                    'gender'
                ]
            ]);
    }
}
