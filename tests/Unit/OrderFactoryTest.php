<?php

namespace Tests\Unit;

use App\Cart\Cart;
use App\Contracts\OrderFactory;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Fluent;
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
     * A basic unit test example.
     *
     * @return void
     */
    public function testReduceStockWhenOrdered()
    {
        extract($this->mockOrder());

        $product_id = $line_items->keys()->first();
        $product    = Product::findOrFail($product_id);

        $this->assertEquals(
            $product->stock,
            $line_items->get($product_id)->new_stock
        );
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
            // Avoid ordering over product's stock
            $quantity = $this->faker->numberBetween(1, $product->stock);

            // Add product to cart
            $cart->addProduct($product, $quantity);

            $total     = $product->price * $quantity;
            $price     = $product->price;
            $stock     = $product->stock;
            $new_stock = $product->stock - $quantity;

            // Cache important values for further assertions
            $line_items->put(
                $product->id,
                new Fluent(
                    compact('quantity', 'total', 'price', 'stock', 'new_stock')
                )
            );
        });

        $order = app(OrderFactory::class)
            ->placeOrder($cart, $user);

        return compact('order', 'line_items');
    }
}
