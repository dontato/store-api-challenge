<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'         => $faker->name,
        'sku'          => $faker->sentence,
        'description'  => $faker->paragraph,
        'price'        => max($faker->randomFloat(2), 1),
        'is_available' => $faker->boolean,
        'stock'        => $faker->randomNumber(4),
    ];
});
