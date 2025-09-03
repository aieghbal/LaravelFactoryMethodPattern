<?php

namespace App\Services;

use App\Contracts\Notifier;

class EmailNotifier implements Notifier
{
    public function send(string $message): string
    {
        return "📧 ایمیل ارسال شد: {$message}";
    }
}
