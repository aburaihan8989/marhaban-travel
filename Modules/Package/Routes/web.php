<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth'], function () {
    // //Print Barcode
    // Route::get('/products/print-barcode', 'BarcodeController@printBarcode')->name('barcode.print');
    //Umroh
    Route::resource('umroh-packages', 'UmrohPackageController');
    //Hajj
    Route::resource('hajj-packages', 'HajjPackageController');
    // //Product Category
    // Route::resource('product-categories', 'CategoriesController')->except('create', 'show');
});

