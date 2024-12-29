<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class WhatsAppChannel
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.auth_token')
        );
    }

    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            return;
        }

        $message = $notification->toWhatsApp($notifiable);

        if (!$message || !setting('whatsapp_notifications', true)) {
            return;
        }

        $whatsappNumber = $notifiable->whatsapp;
        if (!$whatsappNumber) {
            return;
        }

        // Format the number to E.164 format
        $whatsappNumber = '+' . preg_replace('/[^0-9]/', '', $whatsappNumber);

        $this->client->messages->create(
            "whatsapp:{$whatsappNumber}",
            [
                'from' => 'whatsapp:' . config('services.twilio.whatsapp_from'),
                'body' => $message,
            ]
        );
    }
} 