<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;

class GroupService
{
    public function all(): Collection
    {
        return Group::all();
    }

    public function find(int $id): Group
    {
        return Group::findOrFail($id);
    }

    public function create(array $data): Group
    {
        return Group::create($data);
    }

    public function update(int $id, array $data): Group
    {
        $group = $this->find($id);
        $group->update($data);
        return $group;
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }
}
