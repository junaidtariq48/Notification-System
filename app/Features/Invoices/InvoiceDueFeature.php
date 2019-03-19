<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/18/2019
 * Time: 10:51 PM
 */

namespace App\Features\Invoices;


use App\Domains\Invoices\Jobs\LoadInvoicesByCriteriaJob;
use App\Operations\Invoices\DueNotificationOperation;
use Carbon\Carbon;
use Photon\Foundation\Feature;

class InvoiceDueFeature extends Feature
{
    public function handle()
    {
        $invoices = $this->run(LoadInvoicesByCriteriaJob::class,[
            'criteria' => [
                ['paid','=','0'],
                ['due_date','>=',Carbon::now()]
            ],
            'relations' => [
                'tenant'
            ]
        ]);

        $this->run(DueNotificationOperation::class, compact('invoices'));
    }
}
