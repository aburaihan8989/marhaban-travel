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
    //Airline
    Route::resource('airlines', 'AirlineController');
    //Hotel
    Route::resource('hotels', 'HotelController');
    // //Product Category
    // Route::resource('product-categories', 'CategoriesController')->except('create', 'show');
});

