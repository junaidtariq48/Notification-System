<?php

namespace App\Operations\Invoices;


use App\Domains\Invoices\Jobs\InvoiceDueNotificationJob;
use App\Notifications\InvoiceDue;
use Illuminate\Database\Eloquent\Collection;
use Photon\Foundation\Operation;

class DueNotificationOperation extends Operation
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
            $invoice->tenant->notify(new InvoiceDue($invoice->tenant, $invoice->invoice_no, $invoice->due_date));

            //send push notification to user
            $this->run(InvoiceDueNotificationJob::class,[
                'invoice' => $invoice
            ]);

            //to avoid too many request per second
            sleep(1);
        }
    }
}
