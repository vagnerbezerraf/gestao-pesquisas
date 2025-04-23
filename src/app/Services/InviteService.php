<?php

namespace App\Services;

use App\Models\Invite;
use App\Models\Answer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use App\Mail\SurveyInviteMail;
use Illuminate\Support\Str;

class InviteService
{
    public function all(): Collection
    {
        return Invite::with('survey','group')->get();
    }

    public function find(int $id): Invite
    {
        return Invite::findOrFail($id);
    }

    public function create(array $data): Invite
    {
        $data['token'] = (string) Str::uuid();
        return Invite::create($data);
    }

    public function update(int $id, array $data): Invite
    {
        $invite = $this->find($id);
        $invite->update($data);
        return $invite;
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }

    public function send(int $id): Invite
    {
        $invite = $this->find($id);
        Mail::to($invite->email)->send(new SurveyInviteMail($invite));
        $invite->update(['sent_at' => now()]);
        return $invite;
    }

    public function publicShow(string $token)
    {
        $invite = Invite::where('token', $token)->firstOrFail();
        abort_if($invite->status !== 'pending', 403, 'Convite já respondido');
        return $invite->load('survey.questions');
    }

    public function publicSubmit(string $token, array $answers): Collection
    {
        $invite = Invite::where('token', $token)->firstOrFail();
        abort_if($invite->status !== 'pending', 403, 'Convite já respondido');
        $created = collect($answers)->map(function ($item) use ($invite) {
            return Answer::create([
                'survey_id'   => $invite->survey_id,
                'question_id' => $item['question_id'],
                'user_id'     => null,
                'value'       => $item['value'],
            ]);
        });
        $invite->update(['responded_at' => now(), 'status' => 'responded']);
        return $created;
    }
}
