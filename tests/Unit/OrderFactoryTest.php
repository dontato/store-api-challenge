<?php

namespace Tests\Unit;

use App\Cart\Cart;
use App\Contracts\OrderFactory;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderFactoryTest extends TestCase
{
    use WithFaker;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testOrderIsPlaced()
    {
        extract($this->mockOrder());

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals($line_items->sum('total'), $order->total);
        $this->assertEquals($line_items->sum('quantity'), $order->total_products);
    }

    /**
     * Place an order and return that order and expected line items
     * @return array
     */
    public function mockOrder()
    {
        $products   = factory(Product::class, 3)->create();
        $user       = factory(User::class)->create();
        $cart       = new Cart;
        $line_items = collect();

        $products->each(function ($product) use ($line_items, $cart) {
            // Avoid ordering 0 products
            $quantity = max(1, $this->faker->randomNumber(1));
            // Avoid ordering over product's stock
            $quantity = min($quantity, $product->stock);

            // Add product to cart
            $cart->addProduct($product, $quantity);

            $total = $product->price * $quantity;
            $price = $product->price;

            // Cache important values for further assertions
            $line_items->put(
                $product->id,
                compact('quantity', 'total', 'price')
            );
        });

        $order = app(OrderFactory::class)
            ->placeOrder($cart, $user);

        return compact('order', 'line_items');
    }
}
