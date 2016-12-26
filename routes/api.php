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

Route::get('/shop/recommend', 'ShopController@recommend');
Route::get('/shop/arround', 'ShopController@arround');
Route::get('/shop/show', 'ShopController@show');

Route::get('/discover/links', 'LinkController@all');

Route::get('/comment/by_shop', 'CommentController@byShop');
