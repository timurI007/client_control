<?php

namespace App\Services\MessageSenders;

class TelegramSenderService implements MessageSenderInterface
{
    public function send(string $telegram, string $message): bool
    {
        // send telegram code logic
        return true;
    }
}