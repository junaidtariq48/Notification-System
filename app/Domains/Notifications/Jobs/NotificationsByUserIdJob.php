<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/18/2019
 * Time: 8:55 PM
 */

namespace App\Domains\Notifications\Jobs;


use Illuminate\Support\Facades\DB;

class NotificationsByUserIdJob
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
            ->get();

        return $notifications;
    }
}
