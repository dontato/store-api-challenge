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
    });
