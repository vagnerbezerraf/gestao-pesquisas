<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'text' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['text', 'multiple_choice']),
            'options' => $this->faker->optional()->randomElement([
                null,
                ['choices' => ['Option 1', 'Option 2', 'Option 3']],
            ]),
        ];
    }
}
