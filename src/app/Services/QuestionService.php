<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class QuestionService
{
    public function all(): Collection
    {
        return Question::all();
    }

    public function find(int $id): Question
    {
        return Question::findOrFail($id);
    }

    public function create(array $data): Question
    {
        return Question::create($data);
    }

    public function update(int $id, array $data): Question
    {
        $question = $this->find($id);
        $question->update($data);
        return $question;
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }
}
