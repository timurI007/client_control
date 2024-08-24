<?php

namespace App\Factories;

use App\Enums\CodeSenderType;
use App\Services\MessageSenders\EmailSenderService;
use App\Services\MessageSenders\MessageSenderInterface;
use App\Services\MessageSenders\SmsSenderService;
use App\Services\MessageSenders\TelegramSenderService;

class MessageSenderFactory
{
    public static function make(CodeSenderType $type): MessageSenderInterface
    {
        return match($type) {
            CodeSenderType::SMS => new SmsSenderService(),
            CodeSenderType::TELEGRAM => new TelegramSenderService(),
            CodeSenderType::EMAIL => new EmailSenderService()
        };
    }
}