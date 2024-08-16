<?php

namespace App\Services\SendCode\Sms;

interface SmsServiceInterface
{
    public function send(string $phone, string $message): bool;
}