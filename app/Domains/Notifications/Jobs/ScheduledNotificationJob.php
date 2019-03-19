<?php

namespace App\Domains\Notifications\Jobs;


use Illuminate\Database\Eloquent\Collection;
use Photon\Foundation\Job;

class ScheduledNotificationJob extends Job
{
    private $invoices;

    function __construct(Collection $invoices)
    {
        $this->invoices = $invoices;
    }

    function handle()
    {
        $dueInvoices = array();
        foreach ($this->invoices as $invoice)
        {
         $dueInvoices[] = [
             'invoice_no' => $invoice->invoice_no,
             'due_date' => $invoice->due_date,
             'status' => 'invoice due'
         ];
        }
        return $dueInvoices;
    }
}
