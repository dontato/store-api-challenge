<?php

namespace App\Providers;

use App\Events\ProductLiked;
use App\Events\ProductUpdated;
use App\Listeners\SaveProductPriceChange;
use App\Listeners\UpdateProductLikeCount;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class     => [
            SendEmailVerificationNotification::class,
        ],
        ProductLiked::class   => [
            UpdateProductLikeCount::class,
        ],
        ProductUpdated::class => [
            SaveProductPriceChange::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
