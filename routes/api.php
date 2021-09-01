<?php

$router = app('Dingo\Api\Routing\Router');

$router->version('v1', function ($route) {
    $route->group(
        [
            'namespace' => 'App\Http\Controllers\Api',
            'middleware' => 'language',
        ],
        function ($route) {
            // Main page
            $route->get('main-page', 'IndexController@index');

            // Auth
            $route->group(['namespace' => 'Auth'], function ($route) {
                $route->post('register', 'RegisterController@register');
                $route->post('login', 'LoginController@login')->name('login');
                $route->post('logout', 'LoginController@logout');
            });


            $route->group(['middleware' => 'auth:api'], function ($route) {
                //User
                $route->group(
                    [
                        'namespace' => 'User',
                        'prefix' => 'user'
                    ],
                    function ($route) {
                        $route->get('', 'ProfileController@user');
                    }
                );

                //Admin
                $route->group(
                    [
                        'middleware' => 'admin',
                        'namespace' => 'Admin',
                        'prefix' => 'admin',
                    ],
                    function ($route) {
                        $route->group(
                            [
                                'prefix' => 'users',
                            ],
                            function ($route) {
                                $route->get('', 'UserController@all');
                            }
                        );
                    }
                );
            });
        });
});
