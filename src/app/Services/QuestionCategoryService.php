<?php

namespace App\Services;

use App\Models\QuestionCategory;
use Illuminate\Database\Eloquent\Collection;

class QuestionCategoryService
{
    public function all(): Collection
    {
        return QuestionCategory::all();
    }

    public function find(int $id): QuestionCategory
    {
        return QuestionCategory::findOrFail($id);
    }

    public function create(array $data): QuestionCategory
    {
        return QuestionCategory::create($data);
    }

    public function update(int $id, array $data): QuestionCategory
    {
        $category = $this->find($id);
        $category->update($data);
        return $category;
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }
}
