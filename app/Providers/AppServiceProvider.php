<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\MailerProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MailerProvider::class, SesProvider::class);
        $this->app->bind(MailerProvider::class, SmtpProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
