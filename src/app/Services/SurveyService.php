<?php

namespace App\Services;

use App\Models\Survey;
use Illuminate\Database\Eloquent\Collection;

class SurveyService
{
    public function all(): Collection
    {
        return Survey::all();
    }

    public function find(int $id): Survey
    {
        return Survey::findOrFail($id);
    }

    public function create(array $data): Survey
    {
        return Survey::create($data);
    }

    public function update(int $id, array $data): Survey
    {
        $survey = $this->find($id);
        $survey->update($data);
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
