<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/19/2019
 * Time: 1:32 AM
 */

namespace App\Domains\Invoices\Jobs;


use App\Data\Models\Invoice;
use App\Events\InvoiceDueEvent;
use Photon\Foundation\Job;

class InvoiceDueNotificationJob extends Job
{
    private $invoice;
    public function __construct(Invoice $invoice )
    {
        $this->invoice = $invoice;
    }

    function handle()
    {
        $push = [
            'event' => 'INVOICE_DUE',
            'invoice_no' => $this->invoice->invoice_no,
            'due_date' => $this->invoice->due_date
        ];
        event(new InvoiceDueEvent($push));
    }
}
