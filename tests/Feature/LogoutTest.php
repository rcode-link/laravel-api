<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_can_logout(): void
    {
        $this->seed();
        $response = $this->actingAs(User::whereEmail('test@example.com')->first())->post('/api/logout');

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
    public function test_cannot_logout(): void
    {
        $this->seed();
        $this->withToken('9|ZYmdmFN9L28M0cAy0xP3yGExd1yESV9BJozCFPiG855a06a5');
        $this->withHeader('Content-Type', 'application/json');
        $this->withHeader('Accept', 'application/json');
        $response = $this->post('/api/logout');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJsonStructure(["message"]);
    }
}
