<?php

namespace App\Providers;

use App\Repositories\EmailEloquent;
use App\Repositories\Interfaces\EmailRepoInterface;
use Illuminate\Support\ServiceProvider;

class EmailRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EmailRepoInterface::class, EmailEloquent::class);
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
