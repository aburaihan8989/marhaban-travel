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
    Route::get('/rewards', 'RewardsController@index')->name('rewards.index');
    Route::get('/rewards/agents-list/{agent_id}', 'RewardsController@show_agents')->name('rewards-agents-list.show-agents');
    Route::get('/rewards/customers-list/{agent_id}', 'RewardsController@show_customers')->name('rewards-customers-list.show-customers');

    //Rewards Payment
    Route::get('/agent-payments/{agent_id}', 'AgentPaymentsController@index')->name('agent-payments.index');
    Route::get('/agent-payments/{agent_id}/create', 'AgentPaymentsController@create')->name('agent-payments.create');
    Route::post('agent-payments/store', 'AgentPaymentsController@store')->name('agent-payments.store');
    Route::get('/agent-payments/{agent_id}/edit/{agentPayment}', 'AgentPaymentsController@edit')->name('agent-payments.edit');
    Route::patch('/agent-payments/update/{agentPayment}', 'AgentPaymentsController@update')->name('agent-payments.update');
    Route::delete('/agent-payments/destroy/{agentPayment}', 'AgentPaymentsController@destroy')->name('agent-payments.destroy');
    Route::get('/agent-payments/{agent_id}/view/{agentPayment}', 'AgentPaymentsController@view')->name('agent-payments.view');

    //Rewards Payment Receipt PDF
    Route::get('/agent-payments/pdf/{id}', function ($id) {
        $agent_payment = \Modules\People\Entities\AgentPayment::findOrFail($id);
        $agent = \Modules\People\Entities\Agent::findOrFail($agent_payment->agent_id);

        $pdf = \PDF::loadView('people::agents.payments.print', [
            'agent_payment' => $agent_payment,
            'agent' => $agent,
        ])->setPaper('a4');

        return $pdf->stream('agent-payments-'. $agent_payment->reference .'.pdf');
    })->name('agent-payments.pdf');

});
