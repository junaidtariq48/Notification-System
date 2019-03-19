<?php
namespace App\Features\Notifications;


use Photon\Foundation\Feature;
use App\Data\Models\Notification;
use Photon\Domains\Data\Jobs\BuildEloquentQueryFromRequestJob;

class NotificationListFeature extends Feature
{
    public function handle()
    {
        return $this->run(BuildEloquentQueryFromRequestJob::class, ['model' => Notification::class]);
    }
}
