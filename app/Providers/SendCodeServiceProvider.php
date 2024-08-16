<?php

namespace App\Providers;

use App\Services\SendCode\Email\EmailService;
use App\Services\SendCode\Email\EmailServiceInterface;
use App\Services\SendCode\SendCodeService;
use App\Services\SendCode\SendCodeServiceInterface;
use App\Services\SendCode\Sms\SmsService;
use App\Services\SendCode\Sms\SmsServiceInterface;
use App\Services\SendCode\Telegram\TelegramService;
use App\Services\SendCode\Telegram\TelegramServiceInterface;
use Illuminate\Support\ServiceProvider;

class SendCodeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SendCodeServiceInterface::class, SendCodeService::class);
        $this->app->bind(SmsServiceInterface::class, SmsService::class);
        $this->app->bind(EmailServiceInterface::class, EmailService::class);
        $this->app->bind(TelegramServiceInterface::class, TelegramService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
