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
Route::post('member/login', 'PublicControllers\Member\LoginController@doLogin')->name('public.member.doLogin');
Route::get('member/profile', 'PublicControllers\Member\ProfileController@profile')->name('public.member.profile');
Route::get('member/logout', 'PublicControllers\Member\LogoutController@logout')->name('public.member.logout');


