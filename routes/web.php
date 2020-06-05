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
Route::get('/', 'HomeController@index')->name('home');


Route::prefix('admin')->group(function(){
	Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::get('/', 'AdminController@index')->name('admin.dashboard');
	Route::get('/category/add','AdminController@showRegisterCategory')->name('showRegCategory');
	Route::post('/category/add', 'AdminController@registerCategory')->name('register.category');
    Route::get('/category','AdminController@categoryDetails')->name('category.details');
	Route::get('/category/edit/{id}','AdminController@categoryEdit')->name('show.edit.category');
	Route::post('/category/update','AdminController@categoryUpdate')->name('edit.category');
	Route::get('/category/delete/{id}','AdminController@categoryDelete')->name('delete.category');
    Route::get('/products/add','AdminController@showaddProducts')->name('show.add.product');
    Route::post('/products/add','AdminController@addProduct')->name('add.product');
    Route::get('/products','AdminController@showAllProducts')->name('show.all.products');
    Route::get('/products/{id}','AdminController@editProducts')->name('edit.products');
    Route::post('/products/update','AdminController@updateProducts')->name('update.products');
    Route::get('/products/delete/{id}','AdminController@deleteProducts')->name('delete.products');
    Route::get('/products/discounts/add','AdminController@showAddDiscountForm')->name('discount.form');
    Route::post('/products/discounts/add','AdminController@addDiscountToProducts')->name('add.discount.to.product');
    Route::get('/transaction','AdminController@admin_transaction')->name('admin_transaction');
    Route::get('/transaction/verif/{id}','AdminController@verifikasi')->name('verifikasi');
    Route::get('/transaction/deliv/{id}','AdminController@delivered')->name('delivery');
});

Route::get('/products','userProducts@showAllProducts')->name('show.products');
Route::get('/products/{id}','userProducts@showProducts')->name('show.specific.products');
Route::post('/products/buy','userThings@itemsAction')->name('itemsaction');
route::get('/province','userThings@get_province');
route::get('/kota/{id}','userThings@get_city');
Route::get('/cost={city_origin}&destination={city_destination}&weight={weight}&courier={courier}','userThings@couriercost');
Route::POST('/products/buy/go','userThings@buyItems')->name('buyitem');
Route::get('/profile',function (){
    return view('profile');
});
Route::get('/trans','userThings@data_transaction')->name('transaction_data');
Route::POST('/trans/update','userThings@proof_of_payment')->name('proof_of_payment');
Route::get('/trans/del/{id}','userThings@cancel_transaction')->name('cancel_transaction');
Route::get('/test','userProducts@tester');



