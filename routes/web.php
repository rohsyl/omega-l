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

            Route::get('settings', 'SettingsController@index')->name('admin.settings');
            Route::post('settings/general', 'SettingsController@saveGeneral')->name('admin.settings.general.save');
            Route::get('settings/flang', 'SettingsController@flang')->name('admin.settings.flang');
            Route::post('settings/flang', 'SettingsController@saveFlang')->name('admin.settings.flang.save');
            Route::get('settings/flangtable', 'SettingsController@langftable')->name('admin.settings.flang.table');
            Route::get('settings/langfadd', 'SettingsController@langfadd')->name('admin.settings.flang.langfadd');
            Route::post('settings/langfcreate', 'SettingsController@langfcreate')->name('admin.settings.flang.langfcreate');
            Route::get('settings/langfedit/{slug}', 'SettingsController@langfedit')->name('admin.settings.flang.langfedit');
            Route::post('settings/langfupdate/{slug}', 'SettingsController@langfupdate')->name('admin.settings.flang.langfupdate');
            Route::get('settings/delete/{slug}', 'SettingsController@langfdelete')->name('admin.settings.flang.langfdelete');
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
            Route::get('user', 'UserController@index')->name('user.index');
            Route::get('user/add', 'UserController@add')->name('user.add');
            Route::post('user/create', 'UserController@create')->name('user.create');
            Route::get('user/edit/{id}', 'UserController@edit')->name('user.edit');
            Route::post('user/edit/{id}', 'UserController@update')->name('user.update');
            Route::get('user/edit/{id}/password', 'UserController@editPassword')->name('user.edit.passwd');
            Route::post('user/edit/{id}/password', 'UserController@updatePassword')->name('user.update.passwd');
            Route::get('user/delete/{id}/{confirm?}', 'UserController@delete')->name('user.delete');
            Route::get('user/enable/{id}/{enable}', 'UserController@enable')->name('user.enable');

            Route::get('group', 'GroupController@index')->name('group.index');
            Route::get('group/add', 'GroupController@add')->name('group.add');
            Route::post('group/create', 'GroupController@create')->name('group.create');
            Route::get('group/edit/{id}', 'GroupController@edit')->name('group.edit');
            Route::post('group/edit/{id}', 'GroupController@update')->name('group.update');
            Route::get('group/delete/{id}/{confirm?}', 'GroupController@delete')->name('group.delete');
            Route::get('group/enable/{id}/{enable}', 'GroupController@enable')->name('group.enable');

            Route::get('pages/getTable', 'PagesController@getTable');
            Route::get('pages/add/{lang?}', 'PagesController@add')->name('admin.pages.add');
            Route::get('pages/getPagesLevelZeroBylang', 'PagesController@getPagesLevelZeroBylang')->name('admin.pages.getPagesLevelZeroBylang');
            Route::get('pages/moduleareaList/{pageId}', 'PagesController@moduleareaList')->name('admin.pages.moduleareaList');
            Route::post('pages/create', 'PagesController@create')->name('admin.pages.create');
            Route::get('pages/edit/{id}', 'PagesController@edit')->name('admin.pages.edit');
            Route::get('pages/delete/{id}/{confirmed?}', 'PagesController@delete')->name('admin.pages.delete');
            Route::get('pages/enable/{id}/{enable}', 'PagesController@enable')->name('admin.pages.enable');
            Route::get('pages/{lang?}', 'PagesController@index')->name('admin.pages');
            Route::post('pages/chooselang', 'PagesController@chooseLang')->name('admin.pages.chooselang');

            Route::get('media/library', 'MediasController@library')->name('media.library');
            Route::get('media/library/modal', 'MediasController@library_modal')->name('media.library.modal');
            Route::get('media/uploader', 'MediasController@uploader')->name('media.uploader');
            Route::post('media/uploadhandler', 'MediasController@uploadHandler')->name('media.uploadhandler');
            Route::post('media/dc', 'MediasController@getDirectoryContent')->name('media.dc');
            Route::post('media/mkdir', 'MediasController@addfolder')->name('media.mkdir');
            Route::post('media/delete', 'MediasController@delete')->name('media.delete');
            Route::post('media/rn', 'MediasController@rn')->name('media.rn');
            Route::post('media/mkvideo', 'MediasController@mkvideo')->name('media.mkvideo');
            Route::post('media/copyormove', 'MediasController@copyormove')->name('media.copyormove');

            Route::get('member', 'MemberController@index')->name('member.index');
            Route::get('member/addmember', 'MemberController@member_add')->name('member.addmember');
            Route::post('member/createmember', 'MemberController@member_create')->name('member.createmember');
            Route::get('member/editmember/{id}', 'MemberController@member_edit')->name('member.editmember');
            Route::get('member/editmember/{id}/password', 'MemberController@member_edit_password')->name('member.editmember.password');
            Route::post('member/updatemember/{id}', 'MemberController@member_update')->name('member.updatemember');
            Route::get('member/editmember/{id}/password', 'MemberController@member_edit_password')->name('member.editmember.password');
            Route::post('member/editmember/{id}/password', 'MemberController@member_update_password')->name('member.editmember.updatepassword');
            Route::get('member/deletemember/{id}/{confirm?}', 'MemberController@member_delete')->name('member.deletemember');

            Route::get('member/addmembergroup', 'MemberController@membergroup_add')->name('member.addmembergroup');
            Route::post('member/createmembergroup', 'MemberController@membergroup_create')->name('member.createmembergroup');
            Route::get('member/editmembergroup/{id}', 'MemberController@membergroup_edit')->name('member.editmembergroup');
            Route::post('member/updatemembergroup/{id}', 'MemberController@membergroup_update')->name('member.updatemembergroup');
            Route::get('member/deletemembergroup/{id}/{confirm?}', 'MemberController@membergroup_delete')->name('member.deletemembergroup');


            Route::get('apparence/theme', 'ApparenceController@theme')->name('theme.index');
            Route::get('apparence/theme/detail/{name}', 'ApparenceController@theme_detail')->name('theme.detail');
            Route::get('apparence/theme/detail/{name}/ma/list', 'ApparenceController@theme_ma_list')->name('theme.detail.ma.list');
            Route::get('apparence/theme/detail/{name}/ma/add', 'ApparenceController@theme_ma_add')->name('theme.detail.ma.add');
            Route::post('apparence/theme/detail/{name}/ma/create', 'ApparenceController@theme_ma_create')->name('theme.detail.ma.create');
            Route::get('apparence/theme/detail/{name}/ma/delete/{area}', 'ApparenceController@theme_ma_delete')->name('theme.detail.ma.delete');
            Route::get('apparence/theme/useit/{name}', 'ApparenceController@theme_useit')->name('theme.useit');
            Route::get('apparence/theme/install/{name}', 'ApparenceController@theme_install')->name('theme.install');
            Route::get('apparence/theme/uninstall/{name}', 'ApparenceController@theme_uninstall')->name('theme.uninstall');
            Route::get('apparence/theme/delete/{name}', 'ApparenceController@theme_delete')->name('theme.delete');

            Route::get('apparence/editor', 'ApparenceController@editor')->name('editor.index');

            Route::get('apparence/menu', 'ApparenceController@menu')->name('menu.index');
            Route::get('apparence/menu/add', 'ApparenceController@menu_add')->name('menu.add');
            Route::post('apparence/menu/create', 'ApparenceController@menu_create')->name('menu.create');
            Route::get('apparence/menu/edit/{id}', 'ApparenceController@menu_edit')->name('menu.edit');
            Route::get('apparence/menu/edit/{id}/pages/{lang?}', 'ApparenceController@menu_edit_pages')->name('menu.edit.pages');
            Route::post('apparence/menu/update/{id}', 'ApparenceController@menu_update')->name('menu.update');
            Route::get('apparence/menu/delete/{id}/{confirm?}', 'ApparenceController@menu_delete')->name('menu.delete');
            Route::get('apparence/menu/enable/{id}/{enable}', 'ApparenceController@menu_enable')->name('menu.enable');


            Route::get('plugin', 'PluginController@index')->name('admin.plugins');
            Route::get('plugin/install/{name}', 'PluginController@install')->name('admin.plugins.install');
            Route::get('plugin/uninstall/{name}', 'PluginController@uninstall')->name('admin.plugins.uninstall');
            Route::any('plugin/run/{name}/{action}', 'PluginController@run')->name('admin.plugins.run');
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

