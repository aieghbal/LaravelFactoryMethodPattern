<?php
namespace App\Contracts;

interface Notifier
{
    public function send(string $message): string;
}
