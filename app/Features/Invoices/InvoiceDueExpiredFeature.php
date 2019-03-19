<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/18/2019
 * Time: 11:25 PM
 */

namespace App\Features\Invoices;


use App\Data\Models\User;
use App\Domains\Invoices\Jobs\InvoiceDueExpiredNotificationJob;
use App\Domains\Invoices\Jobs\LoadInvoicesByCriteriaJob;
use App\Operations\Invoices\OverdueNotificationOperation;
use Carbon\Carbon;
use Photon\Foundation\Feature;

class InvoiceDueExpiredFeature extends Feature
{
    public function handle()
    {
        $invoices = $this->run(LoadInvoicesByCriteriaJob::class,[
           'criteria' => [
               ['paid','=','0'],
               ['due_date','<',Carbon::now()]
           ],
            'relations' => [
                'tenant'
            ]
        ]);

        $this->run(OverdueNotificationOperation::class, compact('invoices'));
    }
}
