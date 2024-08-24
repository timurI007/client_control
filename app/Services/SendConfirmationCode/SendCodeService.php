<?php

namespace App\Services\SendConfirmationCode;

use App\Enums\CodeSenderType;
use App\Exceptions\SendCodeException;
use App\Factories\MessageSenderFactory;
use Barryvdh\Debugbar\Facades\Debugbar;

class SendCodeService
{
    public function __construct(
        protected ConfirmationCodeService $confirmationCodeService
    ) {}

    public function sendCode(string $destination, CodeSenderType $method): void
    {
        // validation
        if (!$destination) {
            throw new SendCodeException('Your contact information is wrong');
        }

        $expires = $this->confirmationCodeService->getCodeExpiration();
        if ($expires && now()->lessThan($expires)) {
            throw new SendCodeException('Wait ' . abs(time() - strtotime($expires)) . ' seconds to send code again!');
        }

        // prepare message
        $code = $this->confirmationCodeService->generateCode();
        $message = 'Confirmation code is ' . $code;

        // send code
        $messageSender = MessageSenderFactory::make($method);
        if (! $messageSender->send($destination, $message)) {
            throw new SendCodeException('Technical error!');
        }
        Debugbar::info($code); // for using code to test

        // save code
        $this->confirmationCodeService->saveCode($code);
    }
}