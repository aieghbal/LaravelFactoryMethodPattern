<?php
namespace App\Factories;

use App\Contracts\Notifier;
use App\Services\EmailNotifier;
use App\Services\SMSNotifier;

class NotifierFactory
{
    public static function create(string $type): Notifier
    {
        return match ($type) {
            'email' => new EmailNotifier(),
            'sms'   => new SMSNotifier(),
            default => throw new \Exception("Notifier type {$type} پشتیبانی نمی‌شود."),
        };
    }
}
