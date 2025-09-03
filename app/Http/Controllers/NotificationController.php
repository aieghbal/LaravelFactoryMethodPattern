<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Factories\NotifierFactory;

class NotificationController extends Controller
{
    public function send()
    {
        $type = request('type', 'email');

        $notifier = NotifierFactory::create($type);

        return $notifier->send('سلام! این یک تست Factory Method است.');
    }
}
