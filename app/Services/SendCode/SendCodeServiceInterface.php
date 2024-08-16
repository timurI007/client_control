<?php

namespace App\Services\SendCode;

use App\Models\User;

interface SendCodeServiceInterface
{
    const SMS_METHOD = 'sms';
    const MAIL_METHOD = 'mail';
    const TELEGRAM_METHOD = 'telegram';

    const CODE_EXPIRATION = 3; // min

    const CODE_MIN = 10000;
    const CODE_MAX = 99999;

    const CONFIRMATION_CODE_KEY = 'confirmation_code';
    const CODE_EXPIRATION_KEY = 'code_expiration';

    public function sendCode(string $destination, string $method): array;
    public function checkConfirmationCode(?string $enteredCode): bool;
    public function getAvailableMethods(?User $user = null): array;
}