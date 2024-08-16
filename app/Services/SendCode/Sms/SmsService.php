<?php

namespace App\Services\SendCode\Sms;

class SmsService implements SmsServiceInterface
{
    public function send(string $phone, string $message): bool
    {
        // send sms code logic
        return true;
    }
}