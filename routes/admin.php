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
Route::get('/', 'IndexController@index');

Route::post('/shops/get_types', 'ShopController@getTypesByCatId');
Route::post('/one14s/get_types', 'One14Controller@getTypesByCatId');
Route::resource('shops', 'ShopController');
Route::resource('links', 'LinkController');
Route::resource('rents', 'RentController');
Route::resource('one14s', 'One14Controller');
Route::resource('spreads', 'SpreadController');
Route::resource('users', 'UserController');
Route::resource('suggests', 'SuggestController');
Route::resource('magazinePages', 'MagazinePageController');