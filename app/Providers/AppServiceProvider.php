<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force all URLs to be HTTPS when in production or using ngrok
        if (config('app.env') === 'production' || str_contains(config('app.url'), 'ngrok-free.app')) {
            URL::forceScheme('https');

            if (
                isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
                $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
            ) {
                Request::setTrustedProxies(
                    [$_SERVER['REMOTE_ADDR']],
                    Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_PROTO
                );
            }
        }
    }
}
