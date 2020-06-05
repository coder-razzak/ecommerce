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



Route::group(['namespace' => 'Frontend'], function (){
    Route::get('/', 'FrontendController@index');
    Route::get('/category-wise/{slug}', 'FrontendController@categoryWise');
    Route::get('/brand-wise/{slug}', 'FrontendController@brandWise');
    Route::get('/product-view/{product}', 'FrontendController@productView');
});

Auth::routes();
















Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('category', 'CategoryController');
    Route::resource('brand', 'BrandController');
    Route::resource('color', 'ColorController');
    Route::resource('size', 'SizeController');
    Route::resource('product', 'ProductController');
});