<?php

$router->namespace('Auth')
    ->group(function ($router) {
        $router->post('register', 'RegisterController@register')
            ->name('register')
            ->middleware('guest');

        $router->post('login', 'LoginController@login')
            ->name('login')
            ->middleware('guest');

        $router->post('password/remind', 'PasswordController@remind')
            ->name('password.remind')
            ->middleware('guest');
    });
