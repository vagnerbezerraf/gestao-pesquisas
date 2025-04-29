<?php

namespace App\Services;

use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;
use Illuminate\Support\Facades\Log;
use Sendpulse\RestApi\ApiClientException;

class SendPulseService
{
    protected ApiClient $client;

    public function __construct()
    {
        $this->client = new ApiClient(
            config('services.sendpulse.user_id'),
            config('services.sendpulse.secret'),
            new FileStorage(config('services.sendpulse.storage_path'))
        );
    }

    public function sendEmail(string $to, string $subject, string $htmlBody, string $textBody = null): array
    {
        $payload = [
            'html'    => $htmlBody,
            'text'    => $textBody ?? strip_tags($htmlBody),
            'subject' => $subject,
            'from'    => [
                'name'  => config('services.sendpulse.sender_name'),
                'email' => config('services.sendpulse.sender_email'),
            ],
            'to'      => [ ['email' => $to] ],
        ];

        try {
            return $this->client->smtpSendMail($payload);
        } catch (ApiClientException $e) {
            Log::error('SendPulse API error', [
                'http_code' => method_exists($e, 'getHttpCode') ? $e->getHttpCode() : null,
                'response'  => method_exists($e, 'getResponse') ? $e->getResponse() : null,
                'payload'   => $payload,
            ]);
            throw $e;
        }
    }
}
