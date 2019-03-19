<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/19/2019
 * Time: 2:01 AM
 */

namespace App\Domains\Notifications\Jobs;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Photon\Foundation\Job;

class RecentNotificationJob extends Job
{
    private $userId;

    function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    function handle()
    {
        $notifications = DB::table('notifications')
            ->where('notifiable_id', $this->userId)
            ->whereDate('created_at','=',Carbon::today())
            ->get();
        return $notifications;
    }
}
