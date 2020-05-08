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

Route::get('/', 'FrontModuleController@index');

Auth::routes();
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::group(['middleware' => 'auth'], function () {
    
});

Route::get('/home', 'FrontModuleController@index')->name('home');
Route::get('/how-it-works', 'FrontModuleController@howitworks');
Route::get('/types-of-funding', 'FrontModuleController@typesoffunding');
Route::get('/about-advantage-lending', 'FrontModuleController@about');
Route::get('/faq', 'FrontModuleController@faq');
Route::get('/for-attorneys', 'FrontModuleController@forattorneys');
Route::get('/resource', 'FrontModuleController@resources');
Route::get('/contact-us', 'FrontModuleController@contactus');
Route::get('/careers', 'FrontModuleController@careers');
Route::get('/for-brokers', 'FrontModuleController@forbrokers');
Route::get('/crud', 'CrudController@crud')->name('crud');
Route::post('/crud', 'CrudController@crudgenarate')->name('crudgenarate');

//======================== Sitesettings Route Start ===============================//
Route::get('/sitesettings/list','SitesettingsController@show');
Route::get('/sitesettings/create','SitesettingsController@create');
Route::get('/sitesettings/edit/{id}','SitesettingsController@edit');
Route::get('/sitesettings/delete/{id}','SitesettingsController@destroy');
Route::get('/sitesettings','SitesettingsController@index');
Route::get('/sitesettings/export/excel','SitesettingsController@ExportExcel');
Route::get('/sitesettings/export/pdf','SitesettingsController@ExportPDF');
Route::post('/sitesettings','SitesettingsController@store');
Route::post('/sitesettings/ajax','SitesettingsController@ajaxSave');
Route::post('/sitesettings/datatable/ajax','SitesettingsController@datatable');
Route::post('/sitesettings/update/{id}','SitesettingsController@update');
//======================== Sitesettings Route End ===============================//
//======================== Sitesettings Route Start ===============================//
Route::get('/sitesettings/list','SitesettingsController@show');
Route::get('/sitesettings/create','SitesettingsController@create');
Route::get('/sitesettings/edit/{id}','SitesettingsController@edit');
Route::get('/sitesettings/delete/{id}','SitesettingsController@destroy');
Route::get('/sitesettings','SitesettingsController@index');
Route::get('/sitesettings/export/excel','SitesettingsController@ExportExcel');
Route::get('/sitesettings/export/pdf','SitesettingsController@ExportPDF');
Route::post('/sitesettings','SitesettingsController@store');
Route::post('/sitesettings/ajax','SitesettingsController@ajaxSave');
Route::post('/sitesettings/datatable/ajax','SitesettingsController@datatable');
Route::post('/sitesettings/update/{id}','SitesettingsController@update');
//======================== Sitesettings Route End ===============================//
//======================== Slideranimatedtext Route Start ===============================//
Route::get('/slideranimatedtext/list','SlideranimatedtextController@show');
Route::get('/slideranimatedtext/create','SlideranimatedtextController@create');
Route::get('/slideranimatedtext/edit/{id}','SlideranimatedtextController@edit');
Route::get('/slideranimatedtext/delete/{id}','SlideranimatedtextController@destroy');
Route::get('/slideranimatedtext','SlideranimatedtextController@index');
Route::get('/slideranimatedtext/export/excel','SlideranimatedtextController@ExportExcel');
Route::get('/slideranimatedtext/export/pdf','SlideranimatedtextController@ExportPDF');
Route::post('/slideranimatedtext','SlideranimatedtextController@store');
Route::post('/slideranimatedtext/ajax','SlideranimatedtextController@ajaxSave');
Route::post('/slideranimatedtext/datatable/ajax','SlideranimatedtextController@datatable');
Route::post('/slideranimatedtext/update/{id}','SlideranimatedtextController@update');
//======================== Slideranimatedtext Route End ===============================//
//======================== Slidercontent Route Start ===============================//
Route::get('/slidercontent/list','SlidercontentController@show');
Route::get('/slidercontent/create','SlidercontentController@create');
Route::get('/slidercontent/edit/{id}','SlidercontentController@edit');
Route::get('/slidercontent/delete/{id}','SlidercontentController@destroy');
Route::get('/slidercontent','SlidercontentController@index');
Route::get('/slidercontent/export/excel','SlidercontentController@ExportExcel');
Route::get('/slidercontent/export/pdf','SlidercontentController@ExportPDF');
Route::post('/slidercontent','SlidercontentController@store');
Route::post('/slidercontent/ajax','SlidercontentController@ajaxSave');
Route::post('/slidercontent/datatable/ajax','SlidercontentController@datatable');
Route::post('/slidercontent/update/{id}','SlidercontentController@update');
//======================== Slidercontent Route End ===============================//
//======================== Slidercontent Route Start ===============================//
Route::get('/slidercontent/list','SlidercontentController@show');
Route::get('/slidercontent/create','SlidercontentController@create');
Route::get('/slidercontent/edit/{id}','SlidercontentController@edit');
Route::get('/slidercontent/delete/{id}','SlidercontentController@destroy');
Route::get('/slidercontent','SlidercontentController@index');
Route::get('/slidercontent/export/excel','SlidercontentController@ExportExcel');
Route::get('/slidercontent/export/pdf','SlidercontentController@ExportPDF');
Route::post('/slidercontent','SlidercontentController@store');
Route::post('/slidercontent/ajax','SlidercontentController@ajaxSave');
Route::post('/slidercontent/datatable/ajax','SlidercontentController@datatable');
Route::post('/slidercontent/update/{id}','SlidercontentController@update');
//======================== Slidercontent Route End ===============================//
//======================== Howwehelp Route Start ===============================//
Route::get('/howwehelp/list','HowwehelpController@show');
Route::get('/howwehelp/create','HowwehelpController@create');
Route::get('/howwehelp/edit/{id}','HowwehelpController@edit');
Route::get('/howwehelp/delete/{id}','HowwehelpController@destroy');
Route::get('/howwehelp','HowwehelpController@index');
Route::get('/howwehelp/export/excel','HowwehelpController@ExportExcel');
Route::get('/howwehelp/export/pdf','HowwehelpController@ExportPDF');
Route::post('/howwehelp','HowwehelpController@store');
Route::post('/howwehelp/ajax','HowwehelpController@ajaxSave');
Route::post('/howwehelp/datatable/ajax','HowwehelpController@datatable');
Route::post('/howwehelp/update/{id}','HowwehelpController@update');
//======================== Howwehelp Route End ===============================//