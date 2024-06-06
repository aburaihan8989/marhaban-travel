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

    //Customers
    Route::resource('customers', 'CustomersController');
    //Suppliers
    Route::resource('suppliers', 'SuppliersController');
    //Agents
    Route::resource('agents', 'AgentsController');
    //Teams
    Route::resource('teams', 'TeamsController');

    //Rewards
    // Route::resource('rewards', 'RewardsController');
    // Route::get('/umroh-manifest-payments/{umroh_manifest_customer_id}', 'UmrohManifestPaymentsController@index')->name('umroh-manifest-payments.index');
    Route::get('/rewards', 'RewardsController@index')->name('rewards.index');
    Route::get('/rewards/agents-list/{agent_id}', 'RewardsController@show_agents')->name('rewards-agents-list.show-agents');


});
