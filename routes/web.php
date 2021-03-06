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

Route::resource('/author', 'AuthorController');
Route::resource('/magazine', 'MagazineController');
Route::post('/encrypt', 'EncryptController@encrypt');
Route::post('/decrypt', 'DecryptController@decrypt');
//Route::get('/', 'EncryptController@encrypt');
Route::get('/', function () {
    return view('testviews.crypt');
});
//Auth::routes();

