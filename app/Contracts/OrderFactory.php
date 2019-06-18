<?php

namespace App\Contracts;

use App\Contracts\Cart;
use App\Models\User;

interface OrderFactory
{
    /**
     * Create a new order object
     * @param  \App\Contracts\Cart  $cart
     * @param  \App\Models\User     $user
     * @return \App\Contracts\Order|null
     */
    public function placeOrder(Cart $cart, User $user = null);
}
