<?php

namespace App\Services;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AnswerService
{
    public function allBySurvey(int $surveyId): Collection
    {
        return Answer::where('survey_id', $surveyId)->get();
    }

    public function create(array $data): Answer
    {
        return Answer::create($data);
    }

    public function stats(int $surveyId)
    {
        return Answer::select('question_id', 'value', DB::raw('count(*) as total'))
            ->where('survey_id', $surveyId)
            ->groupBy('question_id', 'value')
            ->get();
    }

    /**
     * Get all answers across surveys.
     */
    public function all(): Collection
    {
        return Answer::with('survey','question','user')->get();
    }

    /**
     * Find a single answer by ID.
     */
    public function find(int $id): Answer
    {
        return Answer::findOrFail($id);
    }

    /**
     * Delete an answer by ID.
     */
    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }

    /**
     * Update an existing answer by ID.
     */
    public function update(int $id, array $data): Answer
    {
        $answer = $this->find($id);
        $answer->update($data);
        return $answer;
    }
}
