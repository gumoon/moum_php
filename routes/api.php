<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function(Request $request) {
    return $request->user();
});

Route::post('/common/init', 'CommonController@init');

Route::get('/dial/timeline', 'DialController@timeline');
Route::get('/dial/by_month', 'DialController@byMonth');
Route::post('/dial/create', 'DialController@create');

Route::get('/shop/recommend', 'ShopController@recommend');
Route::get('/shop/arround', 'ShopController@arround');
Route::get('/shop/show', 'ShopController@show');
Route::post('/shop/report_error', 'ShopController@reportError');
Route::get('/shop/timeline', 'ShopController@timeline');
Route::get('/shop/search', 'ShopController@search');

Route::get('/discover/links', 'LinkController@all');

Route::get('/comment/by_shop', 'CommentController@byShop');
Route::post('/comment/create', 'CommentController@create');
Route::get('/comment/timeline', 'CommentController@timeline');

Route::post('/user/login', 'UserController@login');


