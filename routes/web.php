<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes(['verify' => true]);
//Route::get('profile', function () { Only verified users may enter... })->middleware('verified');
Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('admin')->group(function(){
	Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('/', 'AdminController@index')->name('admin.dashboard');
	Route::get('/category/add','AdminController@showRegisterCategory')->name('showRegCategory');
	Route::post('/category/add', 'AdminController@registerCategory')->name('register.category');
    Route::get('/category','AdminController@categoryDetails')->name('category.details');
	Route::get('/category/edit/{id}','AdminController@categoryEdit');
	Route::post('/category/update','AdminController@categoryUpdate')->name('edit.category');
	Route::get('/category/delete/{id}','AdminController@categoryDelete')->name('delete.category');
    Route::get('/products/add','AdminController@showaddProducts')->name('show.add.product');
    Route::post('/products/add','AdminController@addProduct')->name('add.product');
    Route::get('/products','AdminController@showAllProducts')->name('show.all.products');
    Route::get('/products/{id}','AdminController@editProducts')->name('edit.products');
    Route::post('/products/update','AdminController@updateProducts')->name('update.products');
    Route::get('/products/delete/{id}','AdminController@deleteProducts')->name('delete.products');
});

Route::get('/products','userProducts@showAllProducts')->name('show.products');
Route::get('/products/{id}','userProducts@showProducts')->name('show.specific.products');



