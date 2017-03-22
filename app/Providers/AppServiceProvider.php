<?php

namespace App\Providers;

use Bugsnag\Client as BugsnagClient;
use Bugsnag\Handler as BugsnagHandler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        BugsnagHandler::register(
            $bugsnag = BugsnagClient::make(config('services.bugsnag.key'))
        );
    }
}
