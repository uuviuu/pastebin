<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api', 'middleware' => 'auth:api'], function () {
    Route::get('/pastes', 'ApiPasteController@paginate')->name('api.pastes');
    Route::get('/pastes/detail/{paste}', 'ApiPasteController@detail')->name('api.pastes.detail');
    Route::post('/pastes/create', 'ApiPasteController@create')->name('api.pastes.create');
    Route::post('/pastes/remove', 'ApiPasteController@remove')->name('api.pastes.create');
    Route::post('/pastes/complaint', 'ApiPasteController@complaint')->name('api.pastes.create');

    Route::get('/users', 'ApiUserController@paginate')->name('api.users');
    Route::post('/users/ban', 'ApiUserController@ban')->name('api.users.ban');
});