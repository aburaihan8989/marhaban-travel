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

    //PDF Umroh Manifest
    Route::get('/umroh-manifests/pdf/{id}', function ($id) {
        $umroh_manifest = \Modules\Manifest\Entities\UmrohManifest::findOrFail($id);
        $customer = \Modules\People\Entities\Customer::findOrFail($umroh_manifest->customer_id);

        $pdf = \PDF::loadView('manifest::umroh.print', [
            'umroh_manifest' => $umroh_manifest,
            'customer' => $customer,
        ])->setPaper('a4');

        return $pdf->stream('umroh_manifest-'. $umroh_manifest->reference .'.pdf');
    })->name('umroh-manifests.pdf');

    //PDF Umroh Manifest Customer

    //PDF Umroh Manifest Customer Payment


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

});
