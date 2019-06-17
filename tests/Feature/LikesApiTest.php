<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Like;
use Tests\TestCase;

class LikesApiTest extends TestCase
{
    /**
     * Test the index enpoint for products
     *
     * @return void
     */
    public function testIndexEndpointSortedByAz()
    {
        $product  = factory(Product::class)->create();
        $user     = factory(User::class)->create();
        $like     = $user->likes()->create([
            'product_id' => $product->id
        ]);
        $response = $this->actingAs($user)
            ->getJson('/api/products/liked');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'uuid' => $product->uuid
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStoreEndpoint()
    {
        $product = factory(Product::class)->make();
        $user    = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->postJson("/api/products/{$product->uuid}/likes");
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'liked' => true,
        ]);

        $this->assertInstanceOf(
            Like::class,
            $user->likes()
                ->where('product_id', $product->id)
                ->first()
        );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteEndpoint()
    {
        $product  = factory(Product::class)->create();
        $user     = factory(User::class)->create();
        $like     = $user->likes()->create([
            'product_id' => $product->id
        ]);

        $response = $this->actingAs($user)
            ->deleteJson("/api/products/{$product->uuid}/likes");
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'liked' => false,
        ]);
    }
}
