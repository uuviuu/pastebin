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

Route::get('/', 'PasteController@pastes')->name('pastes');
Route::get('/{paste}', 'PasteController@detail')->name('pastes.detail');
Route::post('/', 'PasteController@create')->name('pastes.create');

Route::group(['prefix' => 'users'], function () {
    Route::get('/registration', 'UserController@registration')->name('users.registration');
    Route::post('/registration', 'UserController@createUser')->name('users.create');
});

Route::post('/logout', 'UserController@logout')->name('logout');

