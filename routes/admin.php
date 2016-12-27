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

Route::resource('shops', 'ShopController');
Route::resource('programinfos', 'ProgramInfoController');

//ajax请求都以ajax开头
Route::post('ajax/shops/get_types', 'ShopController@getTypesByCatId');
Route::post('ajax/shops/store', 'ShopController@store');
Route::post('ajax/shops/update/{id}', 'ShopController@update');
Route::post('ajax/programinfos/store', 'ProgramInfoController@store');
Route::post('ajax/programinfos/update/{id}', 'ProgramInfoController@update');
