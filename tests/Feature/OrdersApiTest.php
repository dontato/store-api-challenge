<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Like;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Fluent;
use Tests\TestCase;

class OrdersApiTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStoreEndpoint()
    {
        $cart     = $this->mockCart();
        $response = $this->actingAs($this->mockUser())
            ->postJson("/api/orders", [
                'items' => $cart->toArray(),
            ]);
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'uuid' => $cart->first()->uuid
        ]);
    }

    /**
     * Test the index enpoint for products
     *
     * @return void
     */
    public function testIndexEndpoint()
    {
        $cart     = $this->mockCart();
        $response = $this->actingAs($this->mockUser())
            ->getJson('/api/orders');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'uuid' => $cart->first()->uuid
        ]);
    }

    /**
     * Use same products for both requests
     * @return \App\Models\User
     */
    public function mockCart()
    {
        static $products;

        if (!isset($products)) {
            $products = factory(Product::class, 3)->create([
                'is_available' => 1
            ]);
        }

        return $products->map(function ($product) {
            // Avoid ordering over product's stock
            $quantity = $this->faker->numberBetween(1, $product->stock);
            $uuid     = $product->uuid;
            return new Fluent(compact('uuid', 'quantity'));
        });
    }

    /**
     * Use same user for both requests
     * @return \App\Models\User
     */
    public function mockUser()
    {
        static $user;

        if (!isset($user)) {
            $user = factory(User::class)->create();
        }

        return $user;
    }
}
