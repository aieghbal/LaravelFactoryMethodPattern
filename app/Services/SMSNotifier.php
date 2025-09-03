<?php

namespace App\Services;

use App\Contracts\Notifier;

class SMSNotifier implements Notifier
{
    public function send(string $message): string
    {
        return "📱 پیامک ارسال شد: {$message}";
    }
}
