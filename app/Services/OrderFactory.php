<?php

namespace App\Services;

use App\Contracts\Cart;
use App\Contracts\CartItem;
use App\Contracts\OrderFactory as OrderFactoryContract;
use App\Models\LineItem;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\QueryException;

class OrderFactory implements OrderFactoryContract
{
    /**
     * @inheritdoc
     */
    public function placeOrder(Cart $cart, User $user = null)
    {
        $order = new Order;
        $db    = $order->getConnection();

        $db->beginTransaction();

        try {
            $order->status         = Order::STATUS_PENDING;
            $order->total          = $cart->total();
            $order->total_products = $cart->totalItems();
            $order->user()->associate($user);

            $order->save();

            $cart->items()->each(function (CartItem $item) use ($order) {
                $product             = $item->product();
                $line_item           = new LineItem;
                $line_item->price    = $item->product()->price;
                $line_item->total    = $item->total();
                $line_item->quantity = $item->quantity();
                $line_item->product()->associate($product);
                $line_item->order()->associate($order);
                $line_item->save();

                $product->stock -= $line_item->quantity;
                $product->save();
            });

            $db->commit();
        } catch (QueryException $e) {
            logger($e->getMessage());
            $db->rollback();
            $order = null;
        }

        return $order;
    }
}
