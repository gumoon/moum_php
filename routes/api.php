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

Route::post('/common/init', 'CommonController@init');
Route::post('/common/upload', 'CommonController@upload');

Route::get('/dial/timeline', 'DialController@timeline');
Route::post('/dial/create', 'DialController@create');

Route::get('/shop/recommend', 'ShopController@recommend');
Route::get('/shop/arround', 'ShopController@arround');
Route::get('/shop/show', 'ShopController@show');
Route::post('/shop/report_error', 'ShopController@reportError');
Route::get('/shop/timeline', 'ShopController@timeline');
Route::get('/shop/search', 'ShopController@search');
Route::get('/shop/access_rank_by_month', 'ShopController@accessRankByMonth');

Route::get('/discover/links', 'LinkController@all');

Route::get('/comment/by_shop', 'CommentController@byShop');
Route::post('/comment/create', 'CommentController@create');
Route::get('/comment/timeline', 'CommentController@timeline');

Route::post('/user/login', 'UserController@login');
Route::post('/user/register', 'UserController@register');
Route::post('/user/update', 'UserController@update');
Route::post('/user/reset_password', 'UserController@resetPassword');
Route::post('/user/captcha', 'UserController@captcha');

Route::post('/suggest/create', 'SuggestController@create');

Route::get('/spread/all', 'SpreadController@all');

Route::get('/rent/arround', 'RentController@arround');

Route::get('/one14/categorize', 'One14Controller@categorize');
Route::get('/one14/arround', 'One14Controller@arround');
