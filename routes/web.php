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

//官网
// Route::group(['namespace' => 'Home'], function(){
//     Route::get('/', function () {
//         //return view('welcome');
//         return view('child');
//     });
//     Route::get('/home', function () {
//         //return view('welcome');
//         return view('home');
//     });   
// });

//注册登录那一套路由
Auth::routes();

//网站首页路由
Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');
