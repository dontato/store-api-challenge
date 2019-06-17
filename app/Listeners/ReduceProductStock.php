<?php

namespace App\Listeners;

use App\Events\ProductOrdered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReduceProductStock
{
    /**
     * Handle the event.
     *
     * @param  ProductOrdered  $event
     * @return void
     */
    public function handle(ProductOrdered $event)
    {
        logger('called');
        $product = $event->line_item->product;
        $product->stock -= $event->line_item->quantity;
        $product->save();
    }
}
