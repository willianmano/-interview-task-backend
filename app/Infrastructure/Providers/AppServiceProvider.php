<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     */
    public function register(): void
    {
        Factory::guessFactoryNamesUsing(function ($class) {
            return 'App\\Modules\\Invoices\\Infrastructure\\Database\\Factories\\' . class_basename($class) . 'Factory';
        });
    }

    /**
     * Bootstrap any application services.
     *
     */
    public function boot(): void
    {
        //
    }
}
