<?php

namespace App\Cart;

use App\Contracts\CartItem as CartItemContract;
use App\Contracts\Product;

class Item implements CartItemContract
{
    /**
     * The product
     * @var \App\Contracts\Product
     */
    protected $product;

    /**
     * The product
     * @var int
     */
    protected $quantity;

    /**
     * New cart item instance
     * @param \App\Contracts\Product  $product
     * @param int                     $quantity
     */
    public function __construct(Product $product, $quantity)
    {
        $this->product  = $product;
        $this->quantity = $quantity;
    }

    /**
     * @inheritdoc
     */
    public function total()
    {
        return $this->quantity * $this->product->price();
    }

    /**
     * @inheritdoc
     */
    public function product()
    {
        return $this->product;
    }

    /**
     * @inheritdoc
     */
    public function quantity()
    {
        return $this->quantity;
    }
}
