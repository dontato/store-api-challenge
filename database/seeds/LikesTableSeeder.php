<?php

use App\Models\Like;
use App\Models\Product;
use Illuminate\Database\Seeder;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Like::class, 20)->create([
            'product_id' => Product::inRandomOrder()->first()->id,
        ]);
    }
}
