<?php
namespace App\Domains\Invoices\Jobs;


use Photon\Foundation\Job;
use App\Data\Models\Invoice;
use Photon\Foundation\Exceptions\Exception;

class UpdateInvoiceJob extends Job
{
    private $invoice;

    function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    function handle()
    {
        if( !$this->invoice->update())
        {
            app('db')->rollback();
            throw new Exception('Unable to update invoice.');
        }

        return $this->invoice;
    }

}
