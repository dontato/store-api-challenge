<?php

namespace App\Contracts;

interface CartItem
{
    /**
     * Get total for this item
     * @return float
     */
    public function total();

    /**
     * Get the product
     * @return \App\Contracts\Product
     */
    public function product();

    /**
     * Get the ordered quantity
     * @return int
     */
    public function quantity();
}
