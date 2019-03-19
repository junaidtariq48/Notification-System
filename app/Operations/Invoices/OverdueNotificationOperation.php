<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/19/2019
 * Time: 1:08 AM
 */

namespace App\Operations\Invoices;


use Photon\Foundation\Operation;
use App\Notifications\InvoiceDueExpired;
use Illuminate\Database\Eloquent\Collection;
use App\Domains\Invoices\Jobs\InvoiceDueExpiredNotificationJob;

class OverdueNotificationOperation extends Operation
{
    private $invoices;
    public function __construct(Collection $invoices)
    {
        $this->invoices = $invoices;
    }

    function handle()
    {
        foreach ($this->invoices as $invoice){

            //send email, sms and db notifications
            $invoice->tenant->notify(new InvoiceDueExpired($invoice->tenant, $invoice->invoice_no, $invoice->due_date));

            //send push notification to user
            $this->run(InvoiceDueExpiredNotificationJob::class,[
                'invoice' => $invoice
            ]);

            //to avoid too many request per second
            sleep(1);
        }
    }
}
