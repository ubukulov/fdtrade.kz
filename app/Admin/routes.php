<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('/products', 'ProductController');
    $router->resource('/categories', 'CategoryController');
    $router->resource('/wb-categories', 'WbCategoryController');
    $router->resource('/al-wb-categories', 'AlWbCategoryController');
    $router->resource('/wb-products', 'WbProductController');
    $router->resource('market-places', 'MarketController');
});
