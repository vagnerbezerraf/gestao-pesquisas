<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Survey;
use Tymon\JWTAuth\Facades\JWTAuth;

class SurveyTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_surveys()
    {
        $this->getJson('/api/surveys')->assertStatus(401);
    }

    public function test_user_can_crud_surveys()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $payload = ['title' => 'Test', 'description' => 'Desc', 'status' => 'draft'];

        $create = $this->withHeaders($headers)->postJson('/api/surveys', $payload);
        $create->assertStatus(201)->assertJsonFragment(['title' => 'Test']);
        $id = $create->json('id');

        $this->withHeaders($headers)->getJson('/api/surveys')->assertStatus(200)->assertJsonCount(1);
        $this->withHeaders($headers)->getJson("/api/surveys/$id")->assertStatus(200)->assertJsonFragment(['title' => 'Test']);
        $this->withHeaders($headers)->putJson("/api/surveys/$id", ['title' => 'Updated'])->assertStatus(200)->assertJsonFragment(['title' => 'Updated']);
        $this->withHeaders($headers)->deleteJson("/api/surveys/$id")->assertStatus(204);
        $this->withHeaders($headers)->getJson("/api/surveys/$id")->assertStatus(404);
    }
}
