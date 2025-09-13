# 🎨 Design Pattern in Laravel: Factory Method
This project is a simple example of the Factory Method design pattern in Laravel.
The goal is to learn the concept of Factory Method using a real and straightforward scenario.

---

## 📖 ScenarioWe have a notification system.
The user can receive messages via Email or SMS.
Instead of directly creating instances of classes everywhere with new, we use a Factory Method to centralize the selection of the notification type in one place.

---

## 🚀 Implementation Steps

### 1. Define a Common Interface
```php
// app/Contracts/Notifier.php
namespace App\Contracts;

interface Notifier
{
    public function send(string $message): string;
}
```


### 2. Create the Concrete Classes
```php
// app/Services/EmailNotifier.php
namespace App\Services;

use App\Contracts\Notifier;

class EmailNotifier implements Notifier
{
    public function send(string $message): string
    {
       return "📧 Email sent: {$message}";
    }
}
```
```php
// app/Services/SMSNotifier.php
namespace App\Services;

use App\Contracts\Notifier;

class SMSNotifier implements Notifier
{
    public function send(string $message): string
    {
        return "📱 SMS sent: {$message}";
    }
}
```

###  3. Implement the Factory Method
```php
// app/Factories/NotifierFactory.php
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
            default => throw new \Exception("Notifier type {$type} is not supported."),
        };
    }
}
```


### 4. Use It in a Controller
```php
// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use App\Factories\NotifierFactory;

class NotificationController extends Controller
{
    public function send()
    {
        // این مقدار می‌تونه از request یا config بیاد
        $type = request('type', 'email'); 

        $notifier = NotifierFactory::create($type);

        return $notifier->send('Hello! This is a Factory Method test.');
    }
}
```


### 5. Define the Route
```php
// routes/web.php
use App\Http\Controllers\NotificationController;

Route::get('/notify', [NotificationController::class, 'send']);
```

🔍 Testing

- Go to /notify?type=email
➝ Output: 📧 Email sent: Hello! This is a Factory Method test.
- Go to /notify?type=sms
➝ Output: 📱 SMS sent: Hello! This is a Factory Method test.




📌 Note

Here we:

Created a common interface (Notifier).
Built multiple concrete implementations (EmailNotifier, SMSNotifier).
Used the Factory Method to decide which class to instantiate.
This makes our code loosely coupled and extensible.
[Persian Version](./README.fa.md)
