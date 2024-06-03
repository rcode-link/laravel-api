<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_user_can_register(): void
    {
        $user = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'Password_123',
        ];

        $response = $this->postJson('/api/user/register', $user);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function test_email_required(): void
    {
        $user = [
            'name' => $this->faker->name,
            'password' => 'Password_123',
        ];

        $response = $this->postJson('/api/user/register', $user);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_password_min_len(): void
    {
        $user = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'Pas',
        ];

        $response = $this->postJson('/api/user/register', $user);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function test_password_big_letter(): void
    {
        $user = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'my_password_with_number_123',
        ];

        $response = $this->postJson('/api/user/register', $user);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function test_password_without_number(): void
    {
        $user = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'Pmy_password_with_number_',
        ];

        $response = $this->postJson('/api/user/register', $user);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
