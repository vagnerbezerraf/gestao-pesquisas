<?php

namespace App\Mail;

use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SurveyInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public Invite $invite;

    /**
     * Create a new message instance.
     */
    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        $url = route('survey-response.show', $this->invite->token);

        return $this->subject('Convite para participar da pesquisa')
                    ->view('emails.survey_invite')
                    ->with(['invite' => $this->invite, 'url' => $url]);
    }
}
