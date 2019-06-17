<?php

namespace Tests\Unit;

use App\Models\Like;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class LikeModelTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUpdateLikeCount()
    {
        $product = factory(Product::class)->create();
        $user    = factory(User::class)->create();

        $like = new Like;
        $like->user()->associate($user);
        $like->product()->associate($product);
        $like->save();

        $this->assertEquals(1, $product->like_count);
    }
}
