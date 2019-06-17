<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class ProductsApiTest extends TestCase
{
    /**
     * Test the index enpoint for products
     *
     * @return void
     */
    public function testIndexEndpointSortedByAz()
    {
        $data = [
            'name'         => 'AAAAAAA',
            'is_available' => 1,
        ];
        $product  = factory(Product::class)->create($data);
        $response = $this->getJson('/api/products');
        $response->assertStatus(200);
        $response->assertJsonFragment(array_only($data, 'name'));
    }

    /**
     * Test the index enpoint for products
     *
     * @return void
     */
    public function testIndexEndpointSortedByPopularity()
    {
        $product = factory(Product::class)->create([
            'is_available' => 1,
        ]);
        $users = factory(User::class, 10)->create()
            ->each(function (User $user) use ($product) {
                $product->likes()
                    ->create(['user_id' => $user->id]);
            });

        $response = $this->getJson('/api/products?sort=popularity');
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
    public function testAdminIndexEndpoint()
    {
        $data = [
            'name'         => 'AAAAAAA',
            'is_available' => 0,
        ];
        $product = factory(Product::class)->create($data);
        $user    = factory(User::class)->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)
            ->getJson('/api/admin/products');
        $response->assertStatus(200);
        $response->assertJsonFragment($data);
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
        $user->assignRole('admin');

        $response = $this->actingAs($user)
            ->postJson('/api/admin/products', $product->toArray());
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
        $product = factory(Product::class)->create();
        $user    = factory(User::class)->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)
            ->getJson("/api/admin/products/{$product->uuid}");
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
        $user         = factory(User::class)->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)
            ->putJson(
                "/api/admin/products/{$product->uuid}",
                $data
            );
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
        $product = factory(Product::class)->create();
        $user    = factory(User::class)->create();
        $user->assignRole('admin');

        $response = $this->actingAs($user)
            ->deleteJson("/api/admin/products/{$product->uuid}");
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'uuid' => $product->uuid,
        ]);

        $this->assertNull(Product::find($product->id));
    }
}
