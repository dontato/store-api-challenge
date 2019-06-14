<?php

$router->post('register', 'Auth\RegisterController@register')
    ->name('register')
    ->middleware('guest');

$router->post('login', 'Auth\LoginController@login')
    ->name('login')
    ->middleware('guest');
