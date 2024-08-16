<?php

namespace App\Services\SendCode;

use App\Models\User;
use App\Services\SendCode\Email\EmailServiceInterface;
use App\Services\SendCode\Sms\SmsServiceInterface;
use App\Services\SendCode\Telegram\TelegramServiceInterface;
use App\Exceptions\SendCodeException;
use Barryvdh\Debugbar\Facades\Debugbar;
use Exception;

class SendCodeService implements SendCodeServiceInterface
{
    public function __construct(
        protected SmsServiceInterface $smsService,
        protected EmailServiceInterface $emailService,
        protected TelegramServiceInterface $telegramService
    ) {}
    
    public function getAvailableMethods(?User $user = null): array
    {
        // get users available methods
        return [self::SMS_METHOD, self::MAIL_METHOD, self::TELEGRAM_METHOD];
    }

    public function sendCode(string $destination, string $method): array
    {
        $result = [
            'success' => false,
            'message' => ''
        ];
        try {
            $this->handle($destination, $method);
            $result['success'] = true;
            $result['message'] = "Code was successfully sent to $destination!";
        } catch (SendCodeException $exception) {
            $result['message'] = $exception->getMessage();
        } catch (Exception $exception) {
            $result['message'] = 'Somethinge went wrong :(';
        }
        return $result;
    }

    public function checkConfirmationCode(?string $enteredCode): bool
    {
        if ($enteredCode == $this->getCode()) {
            $this->clear();
            return true;
        }
        return false;
    }

    private function handle(string $destination, string $method): void
    {
        if (!$destination) {
            throw new SendCodeException('Your contact information is wrong');
        }

        if (!in_array($method, $this->getAvailableMethods())) {
            throw new SendCodeException('Choose method to send code');
        }

        $expires = $this->getCodeExpiration();
        if ($expires && now()->lessThan($expires)) {
            throw new SendCodeException('Wait ' . abs(time() - strtotime($expires)) . ' seconds to send code again!');
        }

        $code = $this->generateCode();
        $message = 'Confirmation code is ' . $code;

        $result = false;
        switch ($method) {
            case self::SMS_METHOD:
                $result = $this->smsService->send($destination, $message);
                break;
            case self::MAIL_METHOD:
                $result = $this->emailService->send($destination, $message);
                break;
            case self::TELEGRAM_METHOD:
                $result = $this->telegramService->send($destination, $message);
                break;
        }

        if (!$result) {
            throw new SendCodeException('Technical error!');
        }

        Debugbar::info($code); // for using code to test
        $this->saveCode($code);
    }

    private function generateCode(): int
    {
        return rand(self::CODE_MIN, self::CODE_MAX);
    }

    private function saveCode(int $code): void
    {
        session()->put(self::CONFIRMATION_CODE_KEY, $code);
        session()->put(self::CODE_EXPIRATION_KEY, now()->addMinutes(self::CODE_EXPIRATION));
    }

    private function getCodeExpiration(): string|null
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