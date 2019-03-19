<?php
namespace App\Features\Notifications;


use App\Domains\Notifications\Jobs\RecentNotificationJob;
use Photon\Domains\Http\Jobs\JsonResponseJob;
use Photon\Foundation\Feature;

class RecentFeature extends Feature
{
    private $userId;

    function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    function handle()
    {
        $notifications =  $this->run(RecentNotificationJob::class,[
            'userId' => $this->userId
        ]);

        return $this->run(new JsonResponseJob($notifications));
    }
}
