<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_user_can_login(): void
    {
        $this->seed();
        $user = [
            'email' => 'test@example.com',
           'password' => 'password'
        ];
        $response = $this->postJson('/api/login', $user);

        $response->assertJsonStructure(['data' => ['access_token']]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_wrong_cred():void {
         $user = [
            'email' => 'test@example.com',
           'password' => 'passworD'
        ];
        $response = $this->postJson('/api/login', $user);

        $response->assertStatus(Response::HTTP_NOT_ACCEPTABLE);
    }
}
