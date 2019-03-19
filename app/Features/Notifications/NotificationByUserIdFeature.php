<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/18/2019
 * Time: 8:50 PM
 */

namespace App\Features\Notifications;


use App\Domains\Notifications\Jobs\NotificationsByUserIdJob;
use Photon\Domains\Http\Jobs\JsonResponseJob;
use Photon\Foundation\Feature;

class NotificationByUserIdFeature extends Feature
{
    private $userId;

    function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    function handle()
    {
        $notifications =  $this->run(NotificationsByUserIdJob::class,[
            'userId' => $this->userId
        ]);

        return $this->run(new JsonResponseJob($notifications));
    }
}
