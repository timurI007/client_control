<?php

namespace App\Services\SendCode\Email;

class EmailService implements EmailServiceInterface
{
    public function send(string $email, string $message): bool
    {
        // send email code logic
        return true;
    }
}