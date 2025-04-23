<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Question;
use Tymon\JWTAuth\Facades\JWTAuth;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_questions()
    {
        $this->getJson('/api/questions')->assertStatus(401);
    }

    public function test_create_validation_errors()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $this->withHeaders(['Authorization' => "Bearer $token"])
             ->postJson('/api/questions', [])
             ->assertStatus(422)
             ->assertJsonValidationErrors(['text', 'type']);
    }

    public function test_user_can_crud_questions()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $payload = ['text' => 'Question text', 'type' => 'text', 'options' => null];
        $create = $this->withHeaders($headers)->postJson('/api/questions', $payload);
        $create->assertStatus(201)->assertJsonFragment(['text' => 'Question text']);
        $id = $create->json('id');

        $this->withHeaders($headers)->getJson('/api/questions')->assertStatus(200)->assertJsonCount(1);
        $this->withHeaders($headers)->getJson("/api/questions/$id")->assertStatus(200)->assertJsonFragment(['text' => 'Question text']);
        $this->withHeaders($headers)->putJson("/api/questions/$id", ['text' => 'Updated'])->assertStatus(200)->assertJsonFragment(['text' => 'Updated']);
        $this->withHeaders($headers)->deleteJson("/api/questions/$id")->assertStatus(204);
        $this->withHeaders($headers)->getJson("/api/questions/$id")->assertStatus(404);
    }
}
