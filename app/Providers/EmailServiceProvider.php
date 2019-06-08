<?php

namespace App\Providers;

use App\Services\Email\EmailService;
use App\Services\Email\EmailServiceInterface;
use Illuminate\Support\ServiceProvider;

class EmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EmailServiceInterface::class, EmailService::class);
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
}
