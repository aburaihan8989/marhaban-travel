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

    // {{ #Umroh }}

    //PDF Umroh Manifest
    Route::get('/umroh-manifest-view/pdf/{id}', function ($id) {
        $umroh_manifest = \Modules\Manifest\Entities\UmrohManifest::findOrFail($id);
        $umroh_package = \Modules\Package\Entities\UmrohPackage::findOrFail($umroh_manifest->package_id);
        $customer = \Modules\People\Entities\Customer::findOrFail($umroh_manifest->customer_id);

        $pdf = \PDF::loadView('manifest::umroh.print', [
            'umroh_manifest' => $umroh_manifest,
            'umroh_package' => $umroh_package,
            'customer' => $customer,
        ])->setPaper('a4');

        return $pdf->stream('umroh_manifest-view-'. $umroh_manifest->reference .'.pdf');
    })->name('umroh-manifest-view.pdf');

    //PDF Umroh Manifest Customer
    Route::get('/umroh-manifest-customers/pdf/{id}', function ($id) {
        $umroh_manifest_customer = \Modules\Manifest\Entities\UmrohManifestCustomer::findOrFail($id);
        $customer = \Modules\People\Entities\Customer::findOrFail($umroh_manifest_customer->customer_id);
        $agent = \Modules\People\Entities\Agent::findOrFail($umroh_manifest_customer->agent_id);

        $pdf = \PDF::loadView('manifest::umroh.customers.print', [
            'umroh_manifest_customer' => $umroh_manifest_customer,
            'customer' => $customer,
            'agent' => $agent,
        ])->setPaper('a4');

        return $pdf->stream('umroh_manifest-customers-'. $umroh_manifest_customer->reference .'.pdf');
    })->name('umroh-manifest-customers.pdf');

    //PDF Umroh Manifest Customer Payment
    Route::get('/umroh-manifest-payments/pdf/{id}', function ($id) {
        $umroh_manifest_payment = \Modules\Manifest\Entities\UmrohManifestPayment::findOrFail($id);
        $umroh_manifest_customer = \Modules\Manifest\Entities\UmrohManifestCustomer::findOrFail($umroh_manifest_payment->umroh_manifest_customer_id);
        $customer = \Modules\People\Entities\Customer::findOrFail($umroh_manifest_customer->customer_id);

        $pdf = \PDF::loadView('manifest::umroh.payments.print', [
            'umroh_manifest_payment' => $umroh_manifest_payment,
            'customer' => $customer,
        ])->setPaper('a4');

        return $pdf->stream('umroh_manifest-payments-'. $umroh_manifest_payment->reference .'.pdf');
    })->name('umroh-manifest-payments.pdf');


    //Umroh Manifest
    Route::resource('umroh-manifests', 'UmrohManifestController');
    Route::get('/umroh-manage-manifests/{umroh_manifest}', 'UmrohManifestController@manage')->name('umroh-manage-manifests.manage');

    //Umroh Manifest Customer
    Route::get('/umroh-manifest-customers/{umroh_manifest_id}/create', 'UmrohManifestCustomerController@create')->name('umroh-manifest-customers.create');
    Route::post('/umroh-manifest-customers/store/{umroh_manifest_id}', 'UmrohManifestCustomerController@store')->name('umroh-manifest-customers.store');
    Route::delete('/umroh-manifest-customers/destroy/{umroh_manifest_customer_id}', 'UmrohManifestCustomerController@destroy')->name('umroh-manifest-customers.destroy');
    Route::get('/umroh-manifest-customers/{umroh_manifest_customer_id}/edit', 'UmrohManifestCustomerController@edit')->name('umroh-manifest-customers.edit');
    Route::patch('/umroh-manifest-customers/update/{umroh_manifest_customer_id}', 'UmrohManifestCustomerController@update')->name('umroh-manifest-customers.update');
    Route::get('/umroh-manifest-customers/{umroh_manifest_customer_id}', 'UmrohManifestCustomerController@show')->name('umroh-manifest-customers.show');

    //Umroh Manifest Customer Payment
    Route::get('/umroh-manifest-payments/{umroh_manifest_customer_id}', 'UmrohManifestPaymentsController@index')->name('umroh-manifest-payments.index');
    Route::get('/umroh-manifest-payments/{umroh_manifest_customer_id}/create', 'UmrohManifestPaymentsController@create')->name('umroh-manifest-payments.create');
    Route::post('/umroh-manifest-payments/store/{umroh_manifest_customer_id}', 'UmrohManifestPaymentsController@store')->name('umroh-manifest-payments.store');
    Route::get('/umroh-manifest-payments/{umroh_manifest_customer_id}/edit/{umrohManifestPayment}', 'UmrohManifestPaymentsController@edit')->name('umroh-manifest-payments.edit');
    Route::patch('/umroh-manifest-payments/update/{umrohManifestPayment}', 'UmrohManifestPaymentsController@update')->name('umroh-manifest-payments.update');
    Route::delete('/umroh-manifest-payments/destroy/{umrohManifestPayment}', 'UmrohManifestPaymentsController@destroy')->name('umroh-manifest-payments.destroy');
    Route::get('/umroh-manifest-payments/{umroh_manifest_customer_id}/view/{umrohManifestPayment}', 'UmrohManifestPaymentsController@view')->name('umroh-manifest-payments.view');

    Route::get('/umroh-manifest-payments/{umroh_manifest_customer_id}/refund', 'UmrohManifestPaymentsController@refund')->name('umroh-manifest-payments.refund');

    // {{ #Hajj }}

    //PDF Hajj Manifest
    Route::get('/hajj-manifest-view/pdf/{id}', function ($id) {
        $hajj_manifest = \Modules\Manifest\Entities\HajjManifest::findOrFail($id);
        $hajj_package = \Modules\Package\Entities\HajjPackage::findOrFail($hajj_manifest->package_id);
        $customer = \Modules\People\Entities\Customer::findOrFail($hajj_manifest->customer_id);

        $pdf = \PDF::loadView('manifest::hajj.print', [
            'hajj_manifest' => $hajj_manifest,
            'hajj_package' => $hajj_package,
            'customer' => $customer,
        ])->setPaper('a4');

        return $pdf->stream('hajj_manifest-view-'. $hajj_manifest->reference .'.pdf');
    })->name('hajj-manifest-view.pdf');

    //PDF Hajj Manifest Customer
    Route::get('/hajj-manifest-customers/pdf/{id}', function ($id) {
        $hajj_manifest_customer = \Modules\Manifest\Entities\HajjManifestCustomer::findOrFail($id);
        $customer = \Modules\People\Entities\Customer::findOrFail($hajj_manifest_customer->customer_id);
        $agent = \Modules\People\Entities\Agent::findOrFail($hajj_manifest_customer->agent_id);

        $pdf = \PDF::loadView('manifest::hajj.customers.print', [
            'hajj_manifest_customer' => $hajj_manifest_customer,
            'customer' => $customer,
            'agent' => $agent,
        ])->setPaper('a4');

        return $pdf->stream('hajj_manifest-customers-'. $hajj_manifest_customer->reference .'.pdf');
    })->name('hajj-manifest-customers.pdf');

    //PDF Hajj Manifest Customer Payment
    Route::get('/hajj-manifest-payments/pdf/{id}', function ($id) {
        $hajj_manifest_payment = \Modules\Manifest\Entities\HajjManifestPayment::findOrFail($id);
        $hajj_manifest_customer = \Modules\Manifest\Entities\HajjManifestCustomer::findOrFail($hajj_manifest_payment->hajj_manifest_customer_id);
        $customer = \Modules\People\Entities\Customer::findOrFail($hajj_manifest_customer->customer_id);

        $pdf = \PDF::loadView('manifest::hajj.payments.print', [
            'hajj_manifest_payment' => $hajj_manifest_payment,
            'customer' => $customer,
        ])->setPaper('a4');

        return $pdf->stream('hajj_manifest-payments-'. $hajj_manifest_payment->reference .'.pdf');
    })->name('hajj-manifest-payments.pdf');


    //Hajj Manifest
    Route::resource('hajj-manifests', 'HajjManifestController');
    Route::get('/hajj-manage-manifests/{hajj_manifest}', 'HajjManifestController@manage')->name('hajj-manage-manifests.manage');

    //Hajj Manifest Customer
    Route::get('/hajj-manifest-customers/{hajj_manifest_id}/create', 'HajjManifestCustomerController@create')->name('hajj-manifest-customers.create');
    Route::post('/hajj-manifest-customers/store/{hajj_manifest_id}', 'HajjManifestCustomerController@store')->name('hajj-manifest-customers.store');
    Route::delete('/hajj-manifest-customers/destroy/{hajj_manifest_customer_id}', 'HajjManifestCustomerController@destroy')->name('hajj-manifest-customers.destroy');
    Route::get('/hajj-manifest-customers/{hajj_manifest_customer_id}/edit', 'HajjManifestCustomerController@edit')->name('hajj-manifest-customers.edit');
    Route::patch('/hajj-manifest-customers/update/{hajj_manifest_customer_id}', 'HajjManifestCustomerController@update')->name('hajj-manifest-customers.update');
    Route::get('/hajj-manifest-customers/{hajj_manifest_customer_id}', 'HajjManifestCustomerController@show')->name('hajj-manifest-customers.show');

    //Hajj Manifest Customer Payment
    Route::get('/hajj-manifest-payments/{hajj_manifest_customer_id}', 'HajjManifestPaymentsController@index')->name('hajj-manifest-payments.index');
    Route::get('/hajj-manifest-payments/{hajj_manifest_customer_id}/create', 'HajjManifestPaymentsController@create')->name('hajj-manifest-payments.create');
    Route::post('/hajj-manifest-payments/store/{hajj_manifest_customer_id}', 'HajjManifestPaymentsController@store')->name('hajj-manifest-payments.store');
    Route::get('/hajj-manifest-payments/{hajj_manifest_customer_id}/edit/{hajjManifestPayment}', 'HajjManifestPaymentsController@edit')->name('hajj-manifest-payments.edit');
    Route::patch('/hajj-manifest-payments/update/{hajjManifestPayment}', 'HajjManifestPaymentsController@update')->name('hajj-manifest-payments.update');
    Route::delete('/hajj-manifest-payments/destroy/{hajjManifestPayment}', 'HajjManifestPaymentsController@destroy')->name('hajj-manifest-payments.destroy');
    Route::get('/hajj-manifest-payments/{hajj_manifest_customer_id}/view/{hajjManifestPayment}', 'HajjManifestPaymentsController@view')->name('hajj-manifest-payments.view');

    Route::get('/hajj-manifest-payments/{hajj_manifest_customer_id}/refund', 'HajjManifestPaymentsController@refund')->name('hajj-manifest-payments.refund');

});
