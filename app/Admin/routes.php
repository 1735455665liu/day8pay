<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('/goods',GoodsController::class); //商品管理
    $router->resource('/orders',OrdersController::class);//商品订单
    $router->resource('/users',UserController::class);//用户管理
   $router->resource('/mac',OrdersController::class);//素材管理

    $router->get('/valid', 'WxController@valid');//微信
$router->get('/valid', 'WxController@Wxevent');//微信
    
});
