<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Survey;
use App\Models\Question;
use Tymon\JWTAuth\Facades\JWTAuth;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_answers()
    {
        $survey = Survey::factory()->create();
        $this->getJson("/api/surveys/{$survey->id}/answers")->assertStatus(401);
        $this->postJson("/api/surveys/{$survey->id}/answers", [])->assertStatus(401);
    }

    public function test_user_can_submit_list_and_view_stats_of_answers()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $survey = Survey::factory()->create();
        $question = Question::factory()->create(['type' => 'text', 'options' => null]);

        $payload = [
            'answers' => [
                ['question_id' => $question->id, 'value' => ['answer' => 'yes']],
            ],
        ];

        $this->withHeaders($headers)
             ->postJson("/api/surveys/{$survey->id}/answers", $payload)
             ->assertStatus(201)
             ->assertJsonStructure(['answers' => [['id','survey_id','question_id','user_id','value']]]);

        $this->withHeaders($headers)
             ->getJson("/api/surveys/{$survey->id}/answers")
             ->assertStatus(200)
             ->assertJsonCount(1);

        $this->withHeaders($headers)
             ->getJson("/api/surveys/{$survey->id}/stats")
             ->assertStatus(200)
             ->assertJsonStructure(['stats']);
    }
}
