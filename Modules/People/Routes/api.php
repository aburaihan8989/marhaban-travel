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
Route::get('/customer-network/{agent_id}', 'AgentsController@getCustomerNetwork');
Route::get('/customer-referal-network/{agent_id}', 'AgentsController@getCustomerReferalNetwork');

Route::get('/agent-payment/{agent_id}', 'AgentPaymentsController@getAgentPayment');
