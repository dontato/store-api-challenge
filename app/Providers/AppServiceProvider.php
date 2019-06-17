<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\OrderFactory as OrderFactoryContract;
use App\Services\OrderFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OrderFactoryContract::class, function () {
            return app(OrderFactory::class);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['db']
            ->connection()
            ->getSchemaBuilder()
            ->defaultStringLength(191);
    }
}
