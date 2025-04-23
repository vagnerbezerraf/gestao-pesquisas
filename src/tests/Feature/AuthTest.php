<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_and_login()
    {
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret',
        ];

        $this->postJson('/api/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure(['token']);

        $credentials = [
            'email' => 'john@example.com',
            'password' => 'secret',
        ];

        $this->postJson('/api/login', $credentials)
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_register_validation_errors()
    {
        $this->postJson('/api/register', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_login_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'foo@bar.com',
            'password' => bcrypt('pass'),
        ]);

        $this->postJson('/api/login', [
            'email' => 'foo@bar.com',
            'password' => 'wrong',
        ])->assertStatus(401);
    }
}
