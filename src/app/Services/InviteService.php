<?php

namespace App\Services;

use App\Models\Invite;
use App\Models\Answer;
use App\Models\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use App\Mail\SurveyInviteMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Services\SendPulseService;
use Illuminate\Support\Facades\Config;

class InviteService
{
    private $sendPulse;

    public function __construct(SendPulseService $sendPulseService)
    {
        $this->sendPulse = $sendPulseService;
    }

    public function all(): Collection
    {
        return Invite::with('survey','group')->get();
    }

    public function find(int $id): Invite
    {
        return Invite::findOrFail($id);
    }

    public function create(array $data): Collection
    {
        // Cria um invite para cada e-mail do grupo
        $group = Group::findOrFail($data['group_id']);
        $invites = [];
        foreach ($group->emails ?? [] as $email) {
            $invites[] = Invite::create([
                'survey_id' => $data['survey_id'],
                'group_id'  => $data['group_id'],
                'email'     => $email,
            ]);
        }
        return new Collection($invites);
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
        Log::info("InviteService::send - starting for invite {$invite->id} to {$invite->email}");
        // Envia apenas para o e-mail associado ao invite
        try {
            if (Config::get('invite.mailer') === 'sendpulse') {
                $url  = route('survey-response.show', $invite->token);
                $html = view('emails.survey_invite', ['invite' => $invite, 'url' => $url])->render();
                $this->sendPulse->sendEmail($invite->email, 'Convite para participar da pesquisa', $html);
            } else {
                Mail::to($invite->email)->send(new SurveyInviteMail($invite));
            }
            Log::info("InviteService::send - mail sent for invite {$invite->id}");
        } catch (\Exception $e) {
            Log::error("InviteService::send - error sending invite {$invite->id}: " . $e->getMessage());
            throw $e;
        }
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
