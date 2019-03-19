<?php

use Illuminate\Support\Facades\Route;
use App\Events\InvoiceEvent;
use App\Notifications\InvoicePaid;
use App\Data\Models\User;

Route::group([
    'prefix' => 'notifications'
], function() {
    Route::get('/{user}/recent', function($user){
        $notify = new \App\Http\Controllers\NotificationsController();
        return $notify->getRecentNotifications($user);
    });

    Route::get('/{user}/scheduled', function($user){
        $notify = new \App\Http\Controllers\NotificationsController();
        return $notify->getScheduledNotificatons($user);
    });

    Route::get('/{user}/',function ($user){
        $notify = new \App\Http\Controllers\NotificationsController();
        return $notify->getAllNotificationsById($user);
    });

    Route::get('/', 'NotificationsController@index');
});
