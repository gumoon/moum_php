<?php

/*
|--------------------------------------------------------------------------
| Home Routes
|--------------------------------------------------------------------------
|
| Here is where you can register home routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//租房详情页
Route::get('/rent/profile/{id}', 'RentController@profile');
//黄页详情页
Route::get('/one14/profile/{id}', 'One14Controller@profile');
//新闻详情页
Route::get('/news/detail/{id}', 'NewsController@detail');