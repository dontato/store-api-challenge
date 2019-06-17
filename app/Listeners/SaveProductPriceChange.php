<?php

namespace App\Listeners;

use App\Events\ProductUpdated;
use Illuminate\Contracts\Auth\Factory;

class SaveProductPriceChange
{
    /**
     * Auth factory
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new listener instance
     *
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     * @return void
     */
    public function __construct(Factory $auth)
    {
        $auth->shouldUse('api');
        $this->auth = $auth;
    }

    /**
     * Handle the event.
     *
     * @param  ProductUpdated  $event
     * @return void
     */
    public function handle(ProductUpdated $event)
    {
        $product = $event->product;

        if ($product->isDirty('price')) {
            $old_price = $product->getOriginal('price');
            $new_price = $product->price;

            $product->prices()->create([
                'old_price' => $old_price,
                'new_price' => $new_price,
                'user_id'   => $this->auth->id()
            ]);
        }
    }
}
