<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    use WithFaker;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUpdatePrice()
    {
        $product = factory(Product::class)->create();

        for ($i = 1; $i < 3; $i++) {
            $product->price = $this->faker->randomFloat(2);
            $product->save();

            $this->assertEquals($product->prices->count(), $i);
        }
    }
}
