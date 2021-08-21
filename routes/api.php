<?php

$router = app('Dingo\Api\Routing\Router');

$router->version('v1', function ($route) {
    $route->group(['namespace' => 'App\Http\Controllers\Api'], function ($route) {
        // Main page
        $route->get('main-page', 'IndexController@index');

        // Auth
        $route->group(['namespace' => 'Auth'], function ($route) {
            $route->post('register', 'RegisterController@register');
            $route->post('login', 'LoginController@login')->name('login');
            $route->post('logout', 'LoginController@logout');
        });
    });
});
