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

    //Generate PDF

    //Umroh
    Route::get('/umroh-savings/pdf/{id}', function ($id) {
        $umroh_saving = \Modules\Saving\Entities\Saving::findOrFail($id);
        $customer = \Modules\People\Entities\Customer::findOrFail($umroh_saving->customer_id);
        $agent = \Modules\People\Entities\Agent::findOrFail($umroh_saving->agent_id);

        $pdf = \PDF::loadView('saving::umroh.print', [
            'umroh_saving' => $umroh_saving,
            'customer' => $customer,
            'agent' => $agent,
        ])->setPaper('a4');

        return $pdf->stream('umroh_saving-'. $umroh_saving->reference .'.pdf');
    })->name('umroh-savings.pdf');

    Route::get('/umroh-saving-payments/pdf/{id}', function ($id) {
        $umroh_saving_payment = \Modules\Saving\Entities\SavingPayment::findOrFail($id);
        $umroh_saving = \Modules\Saving\Entities\Saving::findOrFail($umroh_saving_payment->saving_id);
        $customer = \Modules\People\Entities\Customer::findOrFail($umroh_saving->customer_id);
        $agent = \Modules\People\Entities\Agent::findOrFail($umroh_saving->agent_id);

        $pdf = \PDF::loadView('saving::umroh.payments.print', [
            'umroh_saving_payment' => $umroh_saving_payment,
            'customer' => $customer,
            'agent' => $agent,
        ])->setPaper('a4');

        return $pdf->stream('umroh_saving-payments-'. $umroh_saving_payment->reference .'.pdf');
    })->name('umroh-saving-payments.pdf');


    //Hajj
    Route::get('/hajj-savings/pdf/{id}', function ($id) {
        $hajj_saving = \Modules\Saving\Entities\HajjSaving::findOrFail($id);
        $customer = \Modules\People\Entities\Customer::findOrFail($hajj_saving->customer_id);
        $agent = \Modules\People\Entities\Agent::findOrFail($hajj_saving->agent_id);

        $pdf = \PDF::loadView('saving::hajj.print', [
            'hajj_saving' => $hajj_saving,
            'customer' => $customer,
            'agent' => $agent,
        ])->setPaper('a4');

        return $pdf->stream('hajj_saving-'. $hajj_saving->reference .'.pdf');
    })->name('hajj-savings.pdf');

    Route::get('/hajj-saving-payments/pdf/{id}', function ($id) {
        $hajj_saving_payment = \Modules\Saving\Entities\HajjSavingPayment::findOrFail($id);
        $hajj_saving = \Modules\Saving\Entities\HajjSaving::findOrFail($hajj_saving_payment->saving_id);
        $customer = \Modules\People\Entities\Customer::findOrFail($hajj_saving->customer_id);
        $agent = \Modules\People\Entities\Agent::findOrFail($hajj_saving->agent_id);

        $pdf = \PDF::loadView('saving::hajj.payments.print', [
            'hajj_saving_payment' => $hajj_saving_payment,
            'customer' => $customer,
            'agent' => $agent,
        ])->setPaper('a4');

        return $pdf->stream('umroh_hajj-payments-'. $hajj_saving_payment->reference .'.pdf');
    })->name('hajj-saving-payments.pdf');


    //Saving

    //Umroh
    Route::resource('umroh-savings', 'SavingController');

    //Hajj
    Route::resource('hajj-savings', 'HajjSavingController');


    //Payments

    //Umroh
    Route::get('/umroh-saving-payments/{saving_id}', 'SavingPaymentsController@index')->name('umroh-saving-payments.index');
    Route::get('/umroh-saving-payments/{saving_id}/create', 'SavingPaymentsController@create')->name('umroh-saving-payments.create');
    Route::post('/umroh-saving-payments/store', 'SavingPaymentsController@store')->name('umroh-saving-payments.store');
    Route::get('/umroh-saving-payments/{saving_id}/edit/{savingPayment}', 'SavingPaymentsController@edit')->name('umroh-saving-payments.edit');
    Route::patch('/umroh-saving-payments/update/{savingPayment}', 'SavingPaymentsController@update')->name('umroh-saving-payments.update');
    Route::delete('/umroh-saving-payments/destroy/{savingPayment}', 'SavingPaymentsController@destroy')->name('umroh-saving-payments.destroy');
    Route::get('/umroh-saving-payments/{saving_id}/view/{savingPayment}', 'SavingPaymentsController@view')->name('umroh-saving-payments.view');

    Route::get('/umroh-saving-payments/{saving_id}/refund', 'SavingPaymentsController@refund')->name('umroh-saving-payments.refund');

    //Hajj
    Route::get('/hajj-saving-payments/{saving_id}', 'HajjSavingPaymentsController@index')->name('hajj-saving-payments.index');
    Route::get('/hajj-saving-payments/{saving_id}/create', 'HajjSavingPaymentsController@create')->name('hajj-saving-payments.create');
    Route::post('/hajj-saving-payments/store', 'HajjSavingPaymentsController@store')->name('hajj-saving-payments.store');
    Route::get('/hajj-saving-payments/{saving_id}/edit/{hajjsavingPayment}', 'HajjSavingPaymentsController@edit')->name('hajj-saving-payments.edit');
    Route::patch('/hajj-saving-payments/update/{hajjsavingPayment}', 'HajjSavingPaymentsController@update')->name('hajj-saving-payments.update');
    Route::delete('/hajj-saving-payments/destroy/{hajjsavingPayment}', 'HajjSavingPaymentsController@destroy')->name('hajj-saving-payments.destroy');
    Route::get('/hajj-saving-payments/{saving_id}/view/{hajjsavingPayment}', 'HajjSavingPaymentsController@view')->name('hajj-saving-payments.view');

    Route::get('/hajj-saving-payments/{saving_id}/refund', 'HajjSavingPaymentsController@refund')->name('hajj-saving-payments.refund');

});
