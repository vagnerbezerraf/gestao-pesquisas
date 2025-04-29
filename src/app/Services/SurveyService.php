<?php

namespace App\Services;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Collection;

class SurveyService
{
    public function all(): Collection
    {
        return Survey::withCount('questions')->get();
    }

    public function find(int $id): Survey
    {
        return Survey::findOrFail($id);
    }

    public function create(array $data): Survey
    {
        // cria pesquisa e associa perguntas se fornecidas
        $questions = $data['questions'] ?? [];
        unset($data['questions']);
        $survey = Survey::create($data);
        if (!empty($questions)) {
            $survey->questions()->sync($questions);
        }
        return $survey;
    }

    public function update(int $id, array $data): Survey
    {
        // atualiza pesquisa e sincroniza perguntas se fornecidas
        $questions = $data['questions'] ?? null;
        unset($data['questions']);
        $survey = $this->find($id);
        $survey->update($data);
        if (!is_null($questions)) {
            $survey->questions()->sync($questions);
        }
        return $survey;
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }

    public function stats(int $id)
    {
        return $this->find($id)->questions()->withCount('answers')->get();
    }
}
