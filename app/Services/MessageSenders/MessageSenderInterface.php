<?php

namespace App\Services\MessageSenders;

interface MessageSenderInterface
{
    public function send(string $recipient, string $message): bool;
}