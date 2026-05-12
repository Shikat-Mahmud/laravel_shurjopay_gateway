# shurjoPay Laravel Integration Demo

This project demonstrates how to integrate the shurjoPay payment gateway into a Laravel application. Follow these steps to set up and understand the integration process.

## 1. Plugin Integration

While you can use `composer require shurjomukhi/shurjopay-plugin-php` to add the package, this demo uses a direct file integration for maximum control.

### Step 1.1: Copy Plugin Files
Create a directory `app/ShurjopayPlugin` and include the core classes:
- `Shurjopay.php`
- `PaymentRequest.php`
- `ShurjopayConfig.php`
- `ShurjopayValidation.php`
- `ShurjopayException.php`

### Step 1.2: Configure Autoloading
Update your `composer.json` to recognize the new namespace:

```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "ShurjopayPlugin\\": "app/ShurjopayPlugin/"
    }
}
```
Then run:
```bash
composer dump-autoload
```

## 2. Environment Configuration

Add the shurjoPay credentials to your `.env` file:

```env
SP_USERNAME=sp_sandbox
SP_PASSWORD=pyyk97hu&6u6
SP_PREFIX=NOK
SHURJOPAY_API=https://sandbox.shurjopayment.com
SP_CALLBACK=${APP_URL}/shurjopay/callback
SP_LOG_LOCATION=storage/logs
CURLOPT_SSL_VERIFYPEER=1
```

## 3. Service Provider Registration

Create `app/Providers/ShurjopayServiceProvider.php` to manage the plugin's lifecycle:

```php
public function register()
{
    $this->app->singleton(Shurjopay::class, function ($app) {
        $conf = new ShurjopayConfig();
        $conf->username = env('SP_USERNAME');
        // ... set other config from env
        return new Shurjopay($conf);
    });
}
```

Register it in `bootstrap/providers.php` (Laravel 11+):

```php
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\ShurjopayServiceProvider::class,
];
```

## 4. Controller & Routes

### Step 4.1: Create Controller
The `ShurjopayController` handles:
- `index()`: Displays the payment form.
- `pay()`: Validates inputs and initiates the payment.
- `callback()`: Verifies the payment status after redirection.

### Step 4.2: Define Routes
Add the following to `routes/web.php`:

```php
use App\Http\Controllers\ShurjopayController;

Route::get('/shurjopay', [ShurjopayController::class, 'index'])->name('shurjopay.index');
Route::post('/shurjopay/pay', [ShurjopayController::class, 'pay'])->name('shurjopay.pay');
Route::get('/shurjopay/callback', [ShurjopayController::class, 'callback'])->name('shurjopay.callback');
```

## 5. Demo Views

The integration includes two blade templates in `resources/views/shurjopay/`:
- `index.blade.php`: A styled payment form using Bootstrap.
- `response.blade.php`: A summary page to display transaction details (Success/Failure).

## 6. How to Use

1. Start your local server: `php artisan serve`
2. Navigate to `http://localhost:8000/shurjopay`
3. Fill out the form and click **Pay Now**.
4. You will be redirected to the shurjoPay sandbox.
5. After payment, you will be redirected back to the response page.

---
Developed for shurjoPay Demo Integration.

# Modified by
> Saikat Mahmud