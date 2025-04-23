<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Survey;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition()
    {
        return [
            'survey_id'   => Survey::factory(),
            'question_id' => Question::factory(),
            'user_id'     => User::factory(),
            'value'       => ['text' => $this->faker->sentence()],
        ];
    }
}
