<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\MailerProvider;

class SesProvider extends ServiceProvider implements MailerProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Send method implementation
     *
     * @param string $email
     * @param string $message
     * @return boolean
     */
    public function send($email, $message): bool
    {
        return (!empty($email) && !empty($message));
    }
}
