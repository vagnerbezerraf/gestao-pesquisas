<?php

namespace App\Services;

use App\Models\QuestionGroup;
use Illuminate\Database\Eloquent\Collection;

class QuestionGroupService
{
    public function all(): Collection
    {
        return QuestionGroup::all();
    }

    public function find(int $id): QuestionGroup
    {
        return QuestionGroup::findOrFail($id);
    }

    public function create(array $data): QuestionGroup
    {
        return QuestionGroup::create($data);
    }

    public function update(int $id, array $data): QuestionGroup
    {
        $questionGroup = $this->find($id);
        $questionGroup->update($data);
        return $questionGroup;
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }
}
