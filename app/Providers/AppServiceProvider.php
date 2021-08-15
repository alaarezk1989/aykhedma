<?php

namespace App\Providers;

use App\Http\Services\FirebaseService;
use App\Http\Services\PushNotificationInterface;
use App\Http\Services\SendEmailInterface;
use App\Http\Services\SMSProviderInterface;
use App\Http\Services\NexmoSMSService;
use App\Http\Services\SendGridEmailService;
use App\Http\Services\PaymentGatewayInterface;
use App\Http\Services\PayfortService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->app->bind(SMSProviderInterface::class, NexmoSMSService::class);
        $this->app->bind(PaymentGatewayInterface::class, PayfortService::class);
        $this->app->bind(PushNotificationInterface::class, FirebaseService::class);
        $this->app->bind(SendEmailInterface::class, SendGridEmailService::class);
    }
}
