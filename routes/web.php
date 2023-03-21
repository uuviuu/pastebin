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
    Route::get('/registration', 'User\LoginController@registration')->name('users.registration');
    Route::post('/registration', 'User\LoginController@createUser')->name('users.create');
});

Route::post('/logout', 'User\UserController@logout')->name('logout');

Route::get('/auth/{provider}', 'User\LoginController@redirectToProvider')->name('auth.social');
Route::get('/auth/{provider}/callback', 'User\LoginController@handleProviderCallback')->name('auth.social.callback');

