<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'invoices'
], function() {
    Route::get('/', 'InvoicesController@index');
    Route::post('/{id}/status','InvoicesController@invoicePay');
});
