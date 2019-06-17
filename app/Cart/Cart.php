<?php

namespace App\Cart;

use App\Contracts\Cart as CartContract;
use App\Contracts\Product;
use Illuminate\Support\Fluent;

class Cart implements CartContract
{
    /**
     * Products in cart
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    /**
     * New cart instance
     */
    public function __construct()
    {
        $this->items = collect();
    }

    /**
     * @inheritdoc
     */
    public function addProduct(Product $product, $quantity)
    {
        if ($product->stock < $quantity) {
            throw new \InvalidArgumentException(
                "It's not possible to order a quantity greater than product stock"
            );
        }

        $item = new Item($product, $quantity);
        $this->items->push($item);
        return $item;
    }

    /**
     * @inheritdoc
     */
    public function total()
    {
        return $this->items->sum(function ($item) {
            return $item->total();
        });
    }

    /**
     * @inheritdoc
     */
    public function totalItems()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity();
        });
    }

    /**
     * @inheritdoc
     */
    public function items()
    {
        return $this->items;
    }
}
