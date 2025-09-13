# 🎨 Design Pattern in Laravel: Factory Method

این پروژه یک مثال ساده از **الگوی طراحی Factory Method** در لاراول است.  
هدف اینه که با یک سناریوی واقعی و ساده، مفهوم Factory Method رو یاد بگیریم.

---

## 📖 سناریو
ما یک سیستم ارسال اعلان (Notification) داریم.  
کاربر می‌تونه پیام رو از طریق **ایمیل** یا **SMS** دریافت کنه.  
به جای اینکه همه‌جا مستقیم کلاس‌ها رو `new` کنیم، از **Factory Method** استفاده می‌کنیم تا انتخاب نوع اعلان در یک نقطه متمرکز بشه.

---

## 🚀 مراحل پیاده‌سازی

### 1. تعریف Interface مشترک
```php
// app/Contracts/Notifier.php
namespace App\Contracts;

interface Notifier
{
    public function send(string $message): string;
}
```


### 2. ساخت کلاس‌های پیاده‌سازی (Concrete Classes)
```php
// app/Services/EmailNotifier.php
namespace App\Services;

use App\Contracts\Notifier;

class EmailNotifier implements Notifier
{
    public function send(string $message): string
    {
        return "📧 ایمیل ارسال شد: {$message}";
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
        return "📱 پیامک ارسال شد: {$message}";
    }
}
```

###  3. پیاده‌سازی Factory Method
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
            default => throw new \Exception("Notifier type {$type} پشتیبانی نمی‌شود."),
        };
    }
}
```


### 4. استفاده در Controller
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

        return $notifier->send('سلام! این یک تست Factory Method است.');
    }
}
```


### 5. تعریف Route
```php
// routes/web.php
use App\Http\Controllers\NotificationController;

Route::get('/notify', [NotificationController::class, 'send']);
```

🔍 تست

- رفتن به /notify?type=email
➝ خروجی: 📧 ایمیل ارسال شد: سلام! این یک تست Factory Method است.

- رفتن به /notify?type=sms
➝ خروجی: 📱 پیامک ارسال شد: سلام! این یک تست Factory Method است.




📌 نکته

اینجا ما:

یک Interface مشترک ساختیم (Notifier).

چند کلاس پیاده‌سازی مختلف داریم (EmailNotifier, SMSNotifier).

با استفاده از Factory Method تعیین می‌کنیم کدوم کلاس ساخته بشه.
اینطوری کد ما loosely coupled و قابل توسعه میشه.
[نسخه انگلیسی](./README.md)
