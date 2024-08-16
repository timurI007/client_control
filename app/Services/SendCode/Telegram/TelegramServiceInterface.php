<?php

namespace App\Services\SendCode\Telegram;

interface TelegramServiceInterface
{
    public function send(string $telegram, string $message): bool;
}