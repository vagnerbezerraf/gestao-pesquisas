<?php

namespace App\Policies;

use App\Models\QuestionGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionGroupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, QuestionGroup $questionGroup): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, QuestionGroup $questionGroup): bool
    {
        return true;
    }

    public function delete(User $user, QuestionGroup $questionGroup): bool
    {
        return true;
    }
}
