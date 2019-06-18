<?php

$router->namespace('Auth')
    ->group(function ($router) {
        $router->middleware('guest')
            ->group(function ($router) {
                $router->post('register', 'RegisterController@register')
                    ->name('register');

                $router->post('login', 'LoginController@login')
                    ->name('login');

                $router->post('password/remind', 'PasswordController@remind')
                    ->name('password.remind');

                $router->post('password/reset', 'PasswordController@reset')
                    ->name('password.reset');
            });

        $router->put('account', 'AccountController@update')
            ->middleware('auth:api')
            ->name('account');

        $router->post('auth/refresh', 'LoginController@refresh')
            ->middleware('auth:api')
            ->name('refresh');

        $router->get('me', 'LoginController@me')
            ->middleware('auth:api')
            ->name('me');
    });

$router->namespace('Admin')
    ->middleware('auth:api')
    ->middleware('can:manage,App\Models\Product')
    ->name('admin.')
    ->prefix('admin')
    ->group(function ($router) {
        $router->apiResource('products', 'ProductsController');
    });

$router->get('products/liked', 'ProductsController@liked')
    ->middleware('auth:api')
    ->name('products.liked');

$router->post('products/{product}/likes', 'LikesController@store')
    ->middleware('auth:api')
    ->name('products.likes.store');

$router->delete('products/{product}/likes', 'LikesController@destroy')
    ->middleware('auth:api')
    ->name('products.likes.destroy');

$router->apiResource('products', 'ProductsController', [
    'only' => 'index'
]);

$router->apiResource('orders', 'OrdersController', [
    'only' => ['index', 'store']
]);
