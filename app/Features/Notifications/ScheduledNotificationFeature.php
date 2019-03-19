<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/19/2019
 * Time: 2:26 AM
 */

namespace App\Features\Notifications;


use App\Domains\Invoices\Jobs\LoadInvoicesByCriteriaJob;
use App\Domains\Notifications\Jobs\ScheduledNotificationJob;
use Carbon\Carbon;
use Photon\Domains\Http\Jobs\JsonResponseJob;
use Photon\Foundation\Feature;

class ScheduledNotificationFeature extends Feature
{
    private $userId;

    function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    function handle()
    {
        $invoices = $this->run(LoadInvoicesByCriteriaJob::class,[
            'criteria' => [
                ['paid','=','0'],
                ['tenant_id','=',$this->userId],
                ['due_date','>=',Carbon::now()]
            ]
        ]);
        ;
        $notifications =  $this->run(ScheduledNotificationJob::class, compact('invoices'));

        return $this->run(new JsonResponseJob($notifications));
    }

}
