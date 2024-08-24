<?php

namespace App\Enums;

enum CodeSenderType: string
{
    case SMS = 'sms';
    case TELEGRAM = 'telegram';
    case EMAIL = 'email';
}