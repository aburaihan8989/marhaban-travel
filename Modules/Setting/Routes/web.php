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

Route::group(['middleware' => 'auth'], function () {

    //Mail Settings
    Route::patch('/settings/smtp', 'SettingController@updateSmtp')->name('settings.smtp.update');
    //General Settings
    Route::get('/settings', 'SettingController@index')->name('settings.index');
    Route::patch('/settings', 'SettingController@update')->name('settings.update');
    // Units
    Route::resource('units', 'UnitsController')->except('show');

    //Rewards Settings
    Route::get('/settings-rewards', 'SettingController@reward')->name('settings-rewards.index');
    Route::patch('/settings-rewards', 'SettingController@reward_update')->name('settings-rewards.update');
    Route::patch('/settings-rewards-hajj', 'SettingController@reward_hajj_update')->name('settings-rewards-hajj.update');

});
