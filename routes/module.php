<?php

/*
|--------------------------------------------------------------------------
| Modules Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "module" prefix
|
*/



Route::get('language/change/{target}/{referer?}', 'PublicControllers\LanguageController@change')->name('public.language.change');

Route::get('member/login', 'PublicControllers\Member\LoginController@login')->name('public.member.login');


