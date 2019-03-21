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


/********************************************************************
 * Omega CMS must be installed to acces all these routes
 * The *om_not_installed* middleware check if omega is installed,
 * if it's not the case, it redirect the user to the installation
 * page.
 ********************************************************************/
Route::middleware(['om_not_installed', 'om_load_config'])->group(function() {


    /********************************************************************
     * Public admin routes
     ********************************************************************/
    Route::prefix('/admin')->group(function(){
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    });

    /********************************************************************
     * Private admin routes
     ********************************************************************/
    Route::group(['middleware' => ['auth', 'om_backoffice_lang']], function () {
        Route::prefix('admin')->group(function(){
            Route::get('/', config('omega.mvc.defaultcontroller').'@'.config('omega.mvc.defaultaction'))->name('admin.home');

            Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');


            Route::prefix('settings')->group(function(){
                // Settings > General Routes
                Route::get('/', 'SettingsController@index')->name('admin.settings');
                Route::post('general', 'SettingsController@saveGeneral')->name('admin.settings.general.save');

                // Settings > Front-end language Routes
                Route::get('flang', 'SettingsController@flang')->name('admin.settings.flang');
                Route::post('flang', 'SettingsController@saveFlang')->name('admin.settings.flang.save');
                Route::get('flangtable', 'SettingsController@langftable')->name('admin.settings.flang.table');
                Route::get('langfadd', 'SettingsController@langfadd')->name('admin.settings.flang.langfadd');
                Route::post('langfcreate', 'SettingsController@langfcreate')->name('admin.settings.flang.langfcreate');
                Route::get('langfedit/{slug}', 'SettingsController@langfedit')->name('admin.settings.flang.langfedit');
                Route::post('langfupdate/{slug}', 'SettingsController@langfupdate')->name('admin.settings.flang.langfupdate');
                Route::get('delete/{slug}', 'SettingsController@langfdelete')->name('admin.settings.flang.langfdelete');

                // Settings >  SEO
                Route::get('seo', 'SettingsController@seo')->name('admin.settings.seo');
                Route::post('seo', 'SettingsController@saveSeo')->name('admin.settings.seo.save');

                // Settings > Member
                Route::get('member', 'SettingsController@member')->name('admin.settings.member');
                Route::post('member', 'SettingsController@saveMember')->name('admin.settings.member.save');

                // Settings > Advanced
                Route::get('advanced', 'SettingsController@advanced')->name('admin.settings.advanced');
                Route::get('clearcache', 'SettingsController@clearCache')->name('admin.settings.advanced.clearCache');

                // Set the language of the back-office for the current session
                Route::get('setblang/{slug}', 'SettingsController@setBackOfficeLang')->name('admin.settings.setblang');
            });

            Route::get('js/loadmain', 'JsController@loadmain')->name('js.loadmain');
            Route::get('language/loadforjs', 'LanguageController@loadforjs')->name('language.loadforjs');

            Route::post('logout', 'Auth\LoginController@logout')->name('logout');

            Route::prefix('user')->group(function(){
                Route::get('/', 'UserController@index')->name('user.index');
                Route::get('profile/{id?}', 'UserController@profile')->name('profile');
                Route::get('add', 'UserController@add')->name('user.add');
                Route::post('create', 'UserController@create')->name('user.create');
                Route::get('edit/{id}', 'UserController@edit')->name('user.edit');
                Route::post('edit/{id}', 'UserController@update')->name('user.update');
                Route::get('edit/{id}/password', 'UserController@editPassword')->name('user.edit.passwd');
                Route::post('edit/{id}/password', 'UserController@updatePassword')->name('user.update.passwd');
                Route::get('delete/{id}/{confirm?}', 'UserController@delete')->name('user.delete');
                Route::get('enable/{id}/{enable}', 'UserController@enable')->name('user.enable');
            });


            Route::prefix('group')->group(function(){
                Route::get('/', 'GroupController@index')->name('group.index');
                Route::get('add', 'GroupController@add')->name('group.add');
                Route::post('create', 'GroupController@create')->name('group.create');
                Route::get('edit/{id}', 'GroupController@edit')->name('group.edit');
                Route::post('edit/{id}', 'GroupController@update')->name('group.update');
                Route::get('delete/{id}/{confirm?}', 'GroupController@delete')->name('group.delete');
                Route::get('enable/{id}/{enable}', 'GroupController@enable')->name('group.enable');
            });

            Route::prefix('pages')->group(function(){

                Route::get('getPagesLevelZeroBylang/{lang?}', 'PagesController@getPagesLevelZeroBylang')->name('admin.pages.getPagesLevelZeroBylang');
                Route::get('getTable/{lang?}', 'PagesController@getTable')->name('admin.pages.index.table');
                Route::get('getAllPageByParentAndLang/{pid}/{lang}/{idParent?}', 'PagesController@getAllPageByParentAndLang')->name('admin.pages.getbyparentandlang');
                Route::get('add/{lang?}', 'PagesController@add')->name('admin.pages.add');
                Route::post('sort', 'PagesController@sort')->name('admin.pages.sort');
                Route::get('delete/{id}/{confirm?}', 'PagesController@delete')->name('admin.pages.delete');
                Route::get('enable/{id}/{enable}', 'PagesController@enable')->name('admin.pages.enable');
                Route::get('moduleareaList/{pageId}', 'PagesController@moduleareaList')->name('admin.pages.moduleareaList');
                Route::get('moduleList/{pageId}', 'PagesController@moduleList')->name('admin.pages.moduleList');

                Route::prefix('ma')->group(function(){
                    Route::get('plugins/{pageId?}', 'ModuleareaController@listplugin')->name('admin.pages.ma.plugins');
                    Route::get('plugins/{pluginId}/modules/{pageId?}', 'ModuleareaController@listmodulebyplugin')->name('admin.pages.ma.plugins.modules');
                    Route::post('add/{pageId?}', 'ModuleareaController@addPosition')->name('admin.pages.ma.add');
                    Route::post('delete/{id}', 'ModuleareaController@deletePosition')->name('admin.pages.ma.delete');
                    Route::post('setonallpages/{id}/{set}/{pageId?}', 'ModuleareaController@setOnAllPages')->name('admin.pages.ma.setonallpages');
                    Route::post('setorder', 'ModuleareaController@setOrder')->name('admin.pages.ma.setorder');
                    Route::get('lang/{positionid}', 'ModuleareaController@getLangForm')->name('admin.pages.ma.lang');
                    Route::post('langsave', 'ModuleareaController@saveLang')->name('admin.pages.ma.langsave');
                });

                Route::get('componentList/{pageId}', 'PagesController@componentList')->name('admin.pages.componentList');

                Route::get('getCreateFormForModule/{pageId?}', 'PagesController@getCreateFormForModule')->name('admin.pages.getCreateFormForModule');
                Route::post('createModule', 'PagesController@createModule')->name('admin.pages.createModule');
                Route::get('deleteComponent/{id}', 'PagesController@deleteComponent')->name('admin.pages.deleteComponent');
                Route::get('getEditFormForModule/{moduleId}/{pageId?}', 'PagesController@getEditFormForModule')->name('admin.pages.getEditFormForModule');
                Route::post('saveModule/{moduleId}', 'PagesController@saveModule')->name('admin.pages.saveModule');

                Route::get('getCreateFormForComponent/{pageId}', 'PagesController@getCreateFormForComponent')->name('admin.pages.getCreateFormForComponent');
                Route::get('getComponentForm/{id}', 'PagesController@getComponentForm')->name('admin.pages.getComponentForm');
                Route::get('createComponent/{pageId}/{pluginId}', 'PagesController@createComponent')->name('admin.pages.createComponent');
                Route::get('orderComponent/{compId}/{position}', 'PagesController@orderComponent')->name('admin.pages.orderComponent');

                Route::get('getFormComponentSettings/{compId}', 'PagesController@getFormComponentSettings')->name('admin.pages.getFormComponentSettings');
                Route::post('saveSettings/{compId}', 'PagesController@saveSettings')->name('admin.pages.saveSettings');
                Route::post('isComponentsTemplateUpToDate', 'PagesController@isComponentsTemplateUpToDate')->name('admin.pages.isComponentsTemplateUpToDate');

                Route::post('create', 'PagesController@create')->name('admin.pages.create');
                Route::get('edit/{id}/{tab?}', 'PagesController@edit')->name('admin.pages.edit');
                Route::post('update/{id}', 'PagesController@update')->name('admin.pages.update');
                Route::get('delete/{id}/{confirm?}', 'PagesController@delete')->name('admin.pages.delete');
                Route::get('enable/{id}/{enable}', 'PagesController@enable')->name('admin.pages.enable');


                Route::get('trash', 'PagesController@trash')->name('admin.pages.trash');
                Route::get('restore/{id}', 'PagesController@restore')->name('admin.pages.restore');
                Route::get('forcedelete/{id}', 'PagesController@forcedelete')->name('admin.pages.forcedelete');

                Route::get('{lang?}', 'PagesController@index')->name('admin.pages');
                Route::post('chooselang', 'PagesController@chooseLang')->name('admin.pages.chooselang');
            });

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
            Route::get('media/edit/{id}', 'MediasController@editMedia')->name('media.edit');
            Route::post('media/update/{id}', 'MediasController@updateMedia')->name('media.update');
            Route::post('media/update/{id}/thumbnail', 'MediasController@updateMediaThumbnail')->name('media.update.thumbnail');

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
            Route::get('apparence/theme/publish/{name}', 'ApparenceController@theme_publish')->name('theme.publish');
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
            Route::get('plugin/install/{name}/{confirm?}', 'PluginController@install')->name('admin.plugins.install');
            Route::get('plugin/uninstall/{name}/{confirm?}', 'PluginController@uninstall')->name('admin.plugins.uninstall');
            Route::any('plugin/run/{name}/{action}', 'PluginController@run')->name('admin.plugins.run');
            Route::get('plugin/settings/{name}', 'PluginController@settings')->name('admin.plugins.settings');
            Route::get('plugin/publish/{name}', 'PluginController@publish')->name('admin.plugins.publish');

            Route::get('linkchooser/form', 'LinkChooserController@getForm')->name('linkchooser.form');
            Route::get('linkchooser/bc/{id}', 'LinkChooserController@getBreadcrumb')->name('linkchooser.bc');
            Route::get('linkchooser/dc/{id}', 'LinkChooserController@getDirectoryContent')->name('linkchooser.dc');
        });
    });


    /********************************************************************
     * Public routes
     ********************************************************************/

    Route::group(['middleware' => ['om_load_entity']], function () {
        // Homepage
        Route::any('/', 'PublicController@home')
            ->name('public');


        if (OmegaUtils::isInstalled()) {
            if (!om_config('om_enable_front_langauge')) {

                // Page by slug
                Route::any('/{slug}', 'PublicController@slug')
                    ->name('public.byslug');
            } else {

                // Homepage with lang
                Route::any('/{lang}', 'PublicController@home_with_lang')
                    ->where(['lang' => '[a-z]{2}'])
                    ->name('public.homelang');


                // Page by slug and lang
                Route::any('/{lang}/{slug}', 'PublicController@slug_and_lang')
                    ->where(['lang' => '[a-z]{2}'])
                    ->name('public.bylangandslug');

            }
        }

        // Modules
        Route::prefix('/module')->group(function(){
            Route::get('language/change/{target}/{referer?}', 'PublicControllers\LanguageController@change')->name('public.language.change');
        });
    });

});


/********************************************************************
 * The installation must be done only one time.
 * The *om_is_installed* middleware check if omega is installed,
 * if it's the case all these route will return a 404 error.
 ********************************************************************/
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

