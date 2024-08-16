<?php

namespace App\Services\SendCode\Email;

interface EmailServiceInterface
{
    public function send(string $email, string $message): bool;
}