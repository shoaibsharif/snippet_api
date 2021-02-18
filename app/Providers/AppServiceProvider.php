<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
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
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Reset Password URL
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return env('SPA_URL') . "/reset-password/{$token}?email={$notifiable->getEmailForPasswordReset()}";
        });
        // Verify email URL
        VerifyEmail::createUrlUsing(function ($notifiable) {
            $hashEmail = sha1($notifiable->getEmailForVerification());
            $url = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => $hashEmail,
                ]
            );
            $slicedUrl = explode('?', $url)[1];
            return env('SPA_URL') . "/email/verify/{$notifiable->getKey()}/{$hashEmail}?{$slicedUrl}";
        });
    }
}
