<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/19/2019
 * Time: 1:00 AM
 */

namespace App\Domains\Invoices\Jobs;


use App\Data\Models\Invoice;
use App\Events\InvoiceDueExpiredEvent;
use Photon\Foundation\Job;

class InvoiceDueExpiredNotificationJob extends Job
{
    private $invoice;
    public function __construct(Invoice $invoice )
    {
        $this->invoice = $invoice;
    }

    function handle()
    {
        $push = [
            'event' => 'INVOICE_DUE_EXPIRED',
            'invoice_no' => $this->invoice->invoice_no,
            'due_date' => $this->invoice->due_date
        ];
        event(new InvoiceDueExpiredEvent($push));
    }
}
