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
    //return view('welcome');
    return view('admin.login');
});
Route::get('/', function () {
    //return view('welcome');
    return view('admin.index');
});

Route::resource('programs', 'ProgramController');
Route::resource('programinfos', 'ProgramInfoController');

//ajax请求都以ajax开头
Route::post('ajax/programs/store', 'ProgramController@store');
Route::post('ajax/programs/update/{id}', 'ProgramController@update');
Route::post('ajax/programinfos/store', 'ProgramInfoController@store');
Route::post('ajax/programinfos/update/{id}', 'ProgramInfoController@update');
