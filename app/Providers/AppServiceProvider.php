<?php

namespace App\Providers;

use App\Http\Middleware\ApiLoggerMiddleware;
use Illuminate\Support\ServiceProvider;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Configure Monolog logger
        $logger = new Logger('api');
        $logger->pushHandler(new StreamHandler(storage_path('logs/api.log'), Logger::INFO));

        // Bind logger to the API logger middleware
        $this->app->bind('App\Http\Middleware\ApiLoggerMiddleware', function ($app) use ($logger) {
            return new ApiLoggerMiddleware($logger);
        });
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
