<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/info', function () {
    phpinfo();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//购物车
Route::get('/cart', 'CarController@index');
Route::get('/cart/add/{goods_id?}', 'CarController@cartadd');//添加至购物车

//订单处理
Route::get('/index', 'Order\OrderController@index'); //提交订单
Route::get('/olist', 'Order\OrderController@olist'); //订单列表


//微信支付
Route::get('/weixin/pay', 'weixin\WxController@pay');
