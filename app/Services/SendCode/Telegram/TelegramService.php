<?php

namespace App\Services\SendCode\Telegram;

class TelegramService implements TelegramServiceInterface
{
    public function send(string $telegram, string $message): bool
    {
        // send telegram code logic
        return true;
    }
}