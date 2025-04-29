<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use App\Models\Group;
use App\Models\Invite;
use App\Policies\SurveyPolicy;
use App\Policies\QuestionPolicy;
use App\Policies\AnswerPolicy;
use App\Policies\GroupPolicy;
use App\Policies\InvitePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Survey::class => SurveyPolicy::class,
        Question::class => QuestionPolicy::class,
        Answer::class => AnswerPolicy::class,
        Group::class => GroupPolicy::class,
        Invite::class => InvitePolicy::class,
        // QuestionGroup removed
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function(User $user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });
    }
}
