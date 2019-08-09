<?php
Route::middleware(['web', 'om_not_installed', 'om_load_config', 'om_backoffice_lang'])->group(function() {

    Route::group(['prefix' => 'admin/plugin/menu', 'as' => 'admin.plugin_menu.'], function () {
        Route::get('/', 'rohsyl\OmegaPlugin\Menu\Http\Controllers\BController@index')->name('index');
    });


    Route::group(['prefix' => 'module/menu', 'as' => 'module.plugin_menu.'], function () {
        Route::get('/', 'rohsyl\OmegaPlugin\Menu\Http\Controllers\FController@index')->name('index');
    });

});