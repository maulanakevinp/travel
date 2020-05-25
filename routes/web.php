<?php

use App\Helpers\Ipaymu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('/pengaturan', 'UserController@pengaturan')->name('pengaturan');
    Route::get('/edit-profil', 'UserController@editProfil')->name('edit-profil');
    Route::post('/update-avatar', 'UserController@updateAvatar')->name('update-avatar');
    Route::patch('/update-pengaturan', 'UserController@updatePengaturan')->name('update-pengaturan');
    Route::patch('/update-profil', 'UserController@updateProfil')->name('update-profil');


    Route::group(['middleware' => ['can:admin']], function () {

        Route::resource('category', 'CategoryController');
        Route::resource('gallery', 'GalleryController');
        Route::resource('company', 'CompanyController');
        Route::resource('package', 'PackageController');
        Route::resource('order', 'OrderController');
        Route::resource('user', 'UserController');

    });

    Route::group(['middleware' => ['can:member']], function () {

    });

});
