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

Auth::routes();
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::group(['middleware' => 'auth'], function () {
    
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/crud', 'CrudController@crud')->name('crud');
Route::post('/crud', 'CrudController@crudgenarate')->name('crudgenarate');
