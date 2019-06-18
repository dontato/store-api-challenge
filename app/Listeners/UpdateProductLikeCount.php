<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ProductLiked;

class UpdateProductLikeCount
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductLiked  $event
     * @return void
     */
    public function handle(ProductLiked $event)
    {
        $product = $event->like->product;
        $product->like_count = $product->likes()->count();
        $product->save();
    }
}
