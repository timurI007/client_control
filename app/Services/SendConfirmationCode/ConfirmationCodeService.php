<?php

namespace App\Services\SendConfirmationCode;

class ConfirmationCodeService
{
    const SMS_METHOD = 'sms';
    const MAIL_METHOD = 'mail';
    const TELEGRAM_METHOD = 'telegram';

    const CODE_EXPIRATION = 3; // min

    const CODE_MIN = 10000;
    const CODE_MAX = 99999;

    const CONFIRMATION_CODE_KEY = 'confirmation_code';
    const CODE_EXPIRATION_KEY = 'code_expiration';    

    public function checkConfirmationCode(?string $enteredCode): bool
    {
        if ($enteredCode == $this->getCode()) {
            $this->clear();
            return true;
        }
        return false;
    }

    public function generateCode(): int
    {
        return rand(self::CODE_MIN, self::CODE_MAX);
    }

    public function saveCode(int $code): void
    {
        session()->put(self::CONFIRMATION_CODE_KEY, $code);
        session()->put(self::CODE_EXPIRATION_KEY, now()->addMinutes(self::CODE_EXPIRATION));
    }

    public function getCodeExpiration(): string|null
    {
        return session()->get(self::CODE_EXPIRATION_KEY);
    }

    private function getCode(): int|null
    {
        return session()->get(self::CONFIRMATION_CODE_KEY);
    }

    private function clear(): void
    {
        session()->forget(self::CONFIRMATION_CODE_KEY);
        session()->forget(self::CODE_EXPIRATION_KEY);
    }
}