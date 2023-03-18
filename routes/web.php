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

Route::get('paste/{paste_hash}', function () {
    return view('paste');
})->name('paste');

//Route::group(['prefix' => 'pastes'], function () {
//    Route::get('/', 'PasteController@pastes')->name('pastes.paginate');
//    Route::post('/', 'PasteController@create')->name('pastes.create');
//});
