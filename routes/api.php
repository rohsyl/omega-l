<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->group(function() {


    Route::prefix('pages')->group(function(){

        Route::get('get/{id}', 'Api\Pages\PagesController@get')->name('api.pages.get');
    });

    Route::get('languages', 'Api\LanguageController@index')->name('api.languages.index');
});