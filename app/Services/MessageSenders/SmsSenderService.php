<?php

namespace App\Services\MessageSenders;

class SmsSenderService implements MessageSenderInterface
{
    public function send(string $phone, string $message): bool
    {
        // send sms code logic
        return true;
    }
}