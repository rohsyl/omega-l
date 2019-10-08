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


    Route::prefix('page')->group(function(){

        Route::get('/{ignore?}', 'Api\Page\PageController@index')->name('api.pages.index');
        Route::get('/edit/{id}', 'Api\Page\PageController@edit')->name('api.pages.edit');
    });

    Route::get('components/creatable', 'Api\Component\ComponentCreateController@index')->name('api.component.creatable');

    Route::get('languages', 'Api\LanguageController@index')->name('api.languages.index');
});