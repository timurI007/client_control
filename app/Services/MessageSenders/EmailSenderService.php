<?php

namespace App\Services\MessageSenders;

class EmailSenderService implements MessageSenderInterface
{
    public function send(string $email, string $message): bool
    {
        // send email code logic
        return true;
    }
}