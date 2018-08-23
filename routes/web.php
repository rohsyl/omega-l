<?php

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


/**
 * Omega CMS must be installed to acces all these routes
 * The *om_not_installed* middleware check if omega is installed,
 * if it's not the case, it redirect the user to the installation
 * page.
 */
Route::middleware('om_not_installed')->group(function(){

    /**
     * Public routes
     */
    Route::get('/', 'PublicController@index')->name('public');



    /**
     * Public admin routes
     */
    Route::prefix('/admin')->group(function(){
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    });



    /**
     * Private admin routes
     */
    Route::group(['middleware' => 'auth'], function () {
        Route::prefix('admin')->group(function(){
            Route::get('/', config('omega.mvc.defaultcontroller').'@'.config('omega.mvc.defaultaction'))->name('admin.home');
            Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

            Route::get('settings/general', 'SettingsController@index')->name('admin.settings');
            Route::post('settings/general', 'SettingsController@saveGeneral')->name('admin.settings.general.save');

            Route::get('settings/flang', 'SettingsController@flang')->name('admin.settings.flang');
            Route::post('settings/flang', 'SettingsController@saveFlang')->name('admin.settings.flang.save');
            Route::get('settings/flangtable', 'SettingsController@langftable')->name('admin.settings.flang.table');
            Route::get('settings/langfadd', 'SettingsController@langfadd')->name('admin.settings.flang.langfadd');
            Route::post('settings/langfadded', 'SettingsController@langfadded')->name('admin.settings.flang.langfadded');
            Route::get('settings/langfedit', 'SettingsController@langfedit')->name('admin.settings.flang.langfedit');
            Route::post('settings/langfedited', 'SettingsController@langfedited')->name('admin.settings.flang.langfedited');

            Route::get('settings/seo', 'SettingsController@seo')->name('admin.settings.seo');
            Route::post('settings/seo', 'SettingsController@saveSeo')->name('admin.settings.seo.save');

            Route::get('settings/smtp', 'SettingsController@smtp')->name('admin.settings.smtp');
            Route::post('settings/smtp', 'SettingsController@saveSmtp')->name('admin.settings.smtp.save');

            Route::get('settings/member', 'SettingsController@member')->name('admin.settings.member');
            Route::post('settings/member', 'SettingsController@saveMember')->name('admin.settings.member.save');

            Route::get('settings/advanced', 'SettingsController@advanced')->name('admin.settings.advanced');
            Route::get('settings/clearcache', 'SettingsController@clearCache')->name('admin.settings.advanced.clearCache');

            Route::get('js/loadmain', 'JsController@loadmain')->name('js.loadmain');
            Route::get('language/loadforjs', 'LanguageController@loadforjs')->name('language.loadforjs');

            Route::post('logout', 'Auth\LoginController@logout')->name('logout');


            Route::get('user/profile/{id?}', 'UserController@profile')->name('profile');

            Route::get('pages/getTable', 'PagesController@getTable');
            Route::get('pages/{lang?}', 'PagesController@index')->name('admin.pages');
            Route::post('pages/chooselang', 'PagesController@chooseLang')->name('admin.pages.chooselang');
            Route::get('pages/add/{lang?}', 'PagesController@add')->name('admin.pages.add');
        });
    });
});

/**
 * The installation must be done only one time.
 * The *om_is_installed* middleware check if omega is installed,
 * if it's the case all these route will return a 404 error.
 */
Route::middleware('om_is_installed')->group(function(){
    Route::prefix('/install')->group(function(){

        Route::get('/', 'InstallController@index')->name('install.index');
        Route::post('step1', 'InstallController@step1')->name('install.step1');
        Route::get('siteanduser', 'InstallController@siteanduser')->name('install.siteanduser');
        Route::post('step2', 'InstallController@step2')->name('install.step2');
        Route::get('launch', 'InstallController@launch')->name('install.launch');
        Route::post('do', 'InstallController@do')->name('install.do');
        Route::get('finished', 'InstallController@finished')->name('install.finished');

    });
});

