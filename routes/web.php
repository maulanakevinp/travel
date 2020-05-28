<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'HomeController@index');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tour/{tour}/{slug}', 'TourController@show')->name('tour.show');
Route::get('/tour-package/{package}/{slug}', 'TourController@package')->name('tour.package');

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('/pengaturan', 'UserController@pengaturan')->name('pengaturan');
    Route::get('/profil', 'UserController@profil')->name('profil');
    Route::get('/edit-profil', 'UserController@editProfil')->name('edit-profil');
    Route::get('/checkout/{tour}/{slug}', 'OrderController@create')->name('order.create');
    Route::get('/order/{order}', 'OrderController@show')->name('order.show');
    Route::post('/order/{tour}', 'OrderController@store')->name('order.store');
    Route::post('/update-avatar', 'UserController@updateAvatar')->name('update-avatar');
    Route::patch('/update-pengaturan', 'UserController@updatePengaturan')->name('update-pengaturan');
    Route::patch('/update-profil', 'UserController@updateProfil')->name('update-profil');


    Route::group(['middleware' => ['can:admin']], function () {

        Route::resource('package', 'PackageController');
        Route::resource('gallery', 'GalleryController');
        Route::resource('company', 'CompanyController');
        Route::resource('tour', 'TourController')->except('show');
        Route::resource('order', 'OrderController')->except('create','store','show');
        Route::resource('user', 'UserController');

    });

});
