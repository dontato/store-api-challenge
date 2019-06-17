<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Like;
use Illuminate\Foundation\Testing\WithFaker;
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
        $products = factory(Product::class, 3)->create([
            'is_available' => 1
        ]);

        $cart = $products->map(function ($product) {
            // Avoid ordering over product's stock
            $quantity   = $this->faker->numberBetween(1, $product->stock);
            $product_id = $product->id;
            return compact('product_id', 'quantity');
        });

        $response = $this->actingAs($this->mockUser())
            ->postJson("/api/orders", $cart->all());
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'liked' => true,
        ]);
    }

    /**
     * Test the index enpoint for products
     *
     * @return void
     */
    public function testIndexEndpoint()
    {
        $response = $this->actingAs($this->mockUser())
            ->getJson('/api/orders');
        $response->assertStatus(200);
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
