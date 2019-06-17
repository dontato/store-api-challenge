<?php

namespace App\Contracts;

use App\Contracts\Product;

interface Cart
{
    /**
     * Add a product to the cart
     * @param  \App\Contracts\Product $product
     * @param  int                    $quantity
     * @return \App\Contracts\CartItem
     */
    public function addProduct(Product $product, $quantity);

    /**
     * Calculate order total
     * @return int
     */
    public function total();

    /**
     * Calculate order total items
     * @return int
     */
    public function totalItems();

    /**
     * Get the items
     * @return int
     */
    public function items();
}
