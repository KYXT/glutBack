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

            // Posts
            $route->group(['prefix' => 'posts'], function ($route) {
                $route->get('', 'PostController@index');
                $route->get('{slug}', 'PostController@show');
            });

            // Post-Categories
            $route->group(['prefix' => 'post-categories'], function ($route) {
                $route->get('', 'PostCategoryController@index');
                $route->get('{slug}', 'PostCategoryController@show');
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
                        $route->group(
                            [
                                'prefix' => 'posts',
                            ],
                            function ($route) {
                                $route->post('store',  'PostController@store');
                                $route->post('update/{slug}', 'PostController@update');
                                $route->post('delete/{slug}', 'PostController@delete');
                            }
                        );
                        // Post-Categories
                        $route->group(
                            [
                                'prefix' => 'post-categories'
                            ],
                            function ($route) {
                                $route->post('store', 'PostCategoryController@store');
                                $route->post('update/{slug}', 'PostCategoryController@update');
                                $route->post('delete/{slug}', 'PostCategoryController@delete');
                            }
                        );

                        // Product-Categories
                        $route->group(
                            [
                                'prefix' => 'product-categories'
                            ],
                            function ($route) {
                                $route->post('store', 'ProductCategoryController@store');
                                $route->post('update/{slug}', 'ProductCategoryController@update');
                                $route->post('delete/{slug}', 'ProductCategoryController@delete');
                            }
                        );

                        // Product-Subcategories
                        $route->group(
                            [
                                'prefix' => 'product-subcategories'
                            ],
                            function ($route) {
                                $route->post('store', 'ProductSubcategoryController@store');
                                $route->post('update/{slug}', 'ProductSubcategoryController@update');
                                $route->post('delete/{slug}', 'ProductSubcategoryController@delete');
                            }
                        );
                    }
                );
            });
        });
});
