<?php

$router->post('register', 'Auth\RegisterController@register')
    ->middleware('guest');
