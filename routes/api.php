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
    
            // Forum
            $route->group(['prefix' => 'forum-categories'], function ($route) {
                $route->get('',         'ForumCategoryController@index');
                $route->get('{slug}',   'ForumCategoryController@show');
            });

            // Posts
            $route->group(['prefix' => 'posts'], function ($route) {
                $route->get('', 'PostController@index');
                $route->get('{slug}', 'PostController@show');
            });

            // Post-Categories
            $route->group(['prefix' => 'post-categories'], function ($route) {
                $route->get('',         'PostCategoryController@index');
                $route->get('{slug}',   'PostCategoryController@show');
            });

            // Products
            $route->group(['prefix' => 'products'], function ($route) {
                $route->get('',         'ProductController@index');
                $route->get('{slug}',   'ProductController@show');
            });

            // Product-Categories
            $route->group(['prefix' => 'product-categories'], function ($route) {
                $route->get('',         'ProductCategoryController@index');
                $route->get('{slug}',   'ProductCategoryController@show');
            });

            // Product-Categories
            $route->group(['prefix' => 'maps'], function ($route) {
                $route->get('',         'MapController@index');
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
    
                        //Forum topics
                        $route->group(
                            [
                                'prefix' => 'forum-topics',
                            ],
                            function ($route) {
                                $route->post('store',           'ForumTopicController@store');
                                $route->post('update/{slug}',   'ForumTopicController@update');
                                $route->post('close/{slug}',    'ForumTopicController@close');
                                $route->post('delete/{slug}',   'ForumTopicController@delete');
                            }
                        );
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
                        //Forum
                        $route->group(
                            [
                                'prefix' => 'forum',
                            ],
                            function ($route) {
                                $route->group(
                                    [
                                        'prefix' => 'categories',
                                    ],
                                    function ($route) {
                                        $route->post('store',           'ForumCategoryController@store');
                                        $route->post('update/{slug}',   'ForumCategoryController@update');
                                        $route->post('delete/{slug}',   'ForumCategoryController@delete');
                                    }
                                );
                            }
                        );
                        
                        $route->group(
                            [
                                'prefix' => 'users',
                            ],
                            function ($route) {
                                $route->get('', 'UserController@all');
                            }
                        );

                        //Posts
                        $route->group(
                            [
                                'prefix' => 'posts',
                            ],
                            function ($route) {
                                $route->post('store',           'PostController@store');
                                $route->post('update/{slug}',   'PostController@update');
                                $route->post('delete/{slug}',   'PostController@delete');
                            }
                        );

                        // Post-Categories
                        $route->group(
                            [
                                'prefix' => 'post-categories'
                            ],
                            function ($route) {
                                $route->post('store',           'PostCategoryController@store');
                                $route->post('update/{slug}',   'PostCategoryController@update');
                                $route->post('delete/{slug}',   'PostCategoryController@delete');
                            }
                        );

                        //Products
                        $route->group(
                            [
                                'prefix' => 'products',
                            ],
                            function ($route) {
                                $route->post('store',               'ProductController@store');
                                $route->post('update/{slug}',       'ProductController@update');
                                $route->post('delete/{slug}',       'ProductController@delete');
                                $route->post('delete-image/{id}',   'ProductController@deleteImage');
                                $route->post('main-image/{id}',     'ProductController@setMainImage');
                            }
                        );

                        // Product-Categories
                        $route->group(
                            [
                                'prefix' => 'product-categories'
                            ],
                            function ($route) {
                                $route->post('store',           'ProductCategoryController@store');
                                $route->post('update/{slug}',   'ProductCategoryController@update');
                                $route->post('delete/{slug}',   'ProductCategoryController@delete');
                            }
                        );

                        // Product-Subcategories
                        $route->group(
                            [
                                'prefix' => 'product-subcategories'
                            ],
                            function ($route) {
                                $route->post('store',           'ProductSubcategoryController@store');
                                $route->post('update/{slug}',   'ProductSubcategoryController@update');
                                $route->post('delete/{slug}',   'ProductSubcategoryController@delete');
                            }
                        );

                        // Maps
                        $route->group(
                            [
                                'prefix' => 'maps'
                            ],
                            function ($route) {
                                $route->post('store',           'MapController@store');
                                $route->post('update/{id}',     'MapController@update');
                                $route->post('delete/{id}',     'MapController@delete');
                            }
                        );
                    }
                );
            });
        });
});
