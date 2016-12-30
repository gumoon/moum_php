<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//管理后台
Route::get('login', function () {
    return view('admin.login');
});
Route::get('/', function () {
    return view('admin.index');
});

Route::post('/shops/get_types', 'ShopController@getTypesByCatId');
Route::resource('shops', 'ShopController');
