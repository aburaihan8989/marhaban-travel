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

Route::middleware('auth:api')->get('/people', function (Request $request) {
    return $request->user();
});

Route::get('/agent/{agent_id}', 'AgentsController@getAgent');
Route::get('/count-agent-network/{agent_id}', 'AgentsController@getCountAgentNetwork');
Route::get('/count-customer-network/{agent_id}', 'AgentsController@getCountCustomerNetwork');
Route::get('/agent-network/{agent_id}', 'AgentsController@getAgentNetwork');
Route::get('/customer-referal-network/{agent_id}', 'AgentsController@getCustomerReferalNetwork');

Route::get('/agent-payment/{agent_id}', 'AgentPaymentsController@getAgentPayment');

Route::get('/count-potential-customer/{agent_id}', 'AgentsController@getCountPotentialCustomer');

// Customers Network
Route::get('/umroh-customers/{agent_id}', 'AgentsController@getUmrohCustomers');
Route::get('/hajj-customers/{agent_id}', 'AgentsController@getHajjCustomers');
Route::get('/umroh-savings/{agent_id}', 'AgentsController@getUmrohSavingCustomers');
Route::get('/hajj-savings/{agent_id}', 'AgentsController@getHajjSavingCustomers');

Route::post('/mark-umroh-customer/{customer_id}', 'AgentsController@markUmrohCustomer');
Route::post('/mark-hajj-customer/{customer_id}', 'AgentsController@markHajjCustomer');

// Customers Potential
Route::get('/potential-umroh-customers/{agent_id}', 'AgentsController@getPotentialUmrohCustomers');
Route::get('/umroh-customer/{customer_id}', 'AgentsController@getUmrohCustomer');
Route::post('/umroh-customer/{customer_id}', 'AgentsController@postPoinUmrohCustomer');



