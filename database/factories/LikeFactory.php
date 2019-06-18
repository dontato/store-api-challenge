<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Like;
use App\Models\Product;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            return factory(Product::class)->create()->id;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
