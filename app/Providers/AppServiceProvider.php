<?php

namespace App\Providers;

use DB;
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
        DB::connection('alerj')
          ->statement('SET ANSI_NULLS, ANSI_PADDING ON');
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

        $this->registerWarningHandler();
    }

    private function registerWarningHandler()
    {
        set_error_handler(function($warning) {

        }, E_WARNING);
    }
}
