<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class ProductsApiTest extends TestCase
{
    /**
     * Test the index enpoint for products
     *
     * @return void
     */
    public function testIndexEndpointSortedByAz()
    {
        $data     = [
            'name' => 'AAAAAAA',
        ];
        $product  = factory(Product::class)->create($data);
        $response = $this->getJson('/api/products');
        $response->assertStatus(200);
        $response->assertJsonFragment($data);
    }

    /**
     * Test the index enpoint for products
     *
     * @return void
     */
    public function testIndexEndpointSortedByPopularity()
    {
        $users    = factory(User::class, 5)->create();
        $products = factory(Product::class, 3)->create()
            ->each(function (Product $product) use ($users) {
                $users->each(function (User $user) use ($product) {
                    $product->likes()
                        ->create(['user_id' => $user->id]);
                });
            });

        $response = $this->getJson('/api/products?sort=popularity');
        $response->assertStatus(200);

        $products->each(function (Product $product) use ($response) {
            $response->assertJsonFragment([
                'uuid' => $product->uuid,
            ]);
        });
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStoreEndpoint()
    {
        $product  = factory(Product::class)->make();
        $response = $this->postJson('/api/products', $product->toArray());
        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => $product->name,
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testShowEndpoint()
    {
        $product  = factory(Product::class)->create();
        $response = $this->getJson("/api/products/{$product->uuid}");
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'uuid' => $product->uuid,
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateEndpoint()
    {
        $product      = factory(Product::class)->create();
        $data         = $product->toArray();
        $data['name'] = "{$product->name} 2";

        $response = $this->putJson("/api/products/{$product->uuid}", $data);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $data['name'],
            'uuid' => $product->uuid,
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteEndpoint()
    {
        $product  = factory(Product::class)->create();
        $response = $this->deleteJson("/api/products/{$product->uuid}");
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'uuid' => $product->uuid,
        ]);

        $this->assertNull(Product::find($product->id));
    }
}
