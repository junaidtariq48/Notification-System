<?php

namespace App\Http\Controllers;

use App\Features\Notifications\NotificationByUserIdFeature;
use App\Features\Notifications\RecentFeature;
use App\Features\Notifications\ScheduledNotificationFeature;
use Photon\Foundation\Controller;
use Illuminate\Support\Facades\DB;
use App\Features\Notifications\NotificationListFeature;

class NotificationsController extends Controller
{
    public function index()
    {
        return $this->serve(NotificationListFeature::class);
    }

    function getRecentNotifications($id)
    {
        return $this->serve(RecentFeature::class,[
            'userId' => $id
        ]);
    }

    function getScheduledNotificatons($id)
    {
        return $this->serve(ScheduledNotificationFeature::class,[
            'userId' => $id
        ]);
    }

    function getAllNotificationsById($id)
    {
        return $this->serve(NotificationByUserIdFeature::class,[
            'userId' => $id
        ]);
    }

}
