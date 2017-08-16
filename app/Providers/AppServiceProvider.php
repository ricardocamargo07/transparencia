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
        if (app()->environment('production')) {
            DB::connection('alerj')
              ->statement('SET ANSI_NULLS, QUOTED_IDENTIFIER, CONCAT_NULL_YIELDS_NULL, ANSI_WARNINGS, ANSI_PADDING ON');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($key = config('services.bugsnag.key')) {
            BugsnagHandler::register(
                $bugsnag = BugsnagClient::make()
            );
        }

        $this->registerWarningHandler();
    }

    private function registerWarningHandler()
    {
        set_error_handler(function($warning) {

        }, E_WARNING);
    }
}
