<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Telegram\Bot\Api;

class TelegramChannel
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api(config('services.telegram.bot_token'));
    }

    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toTelegram')) {
            return;
        }

        $message = $notification->toTelegram($notifiable);

        if (!$message || !setting('telegram_notifications', true)) {
            return;
        }

        $telegramId = $notifiable->telegram_id;
        if (!$telegramId) {
            return;
        }

        $this->telegram->sendMessage([
            'chat_id' => $telegramId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);
    }
} 