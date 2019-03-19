<?php

namespace App\Features\Invoices;

use App\Data\Models\Invoice;
use App\Domains\Invoices\Jobs\LoadInvoicesByCriteriaJob;
use App\Domains\Invoices\Jobs\UpdateInvoiceJob;
use App\Events\InvoiceEvent;
use App\Notifications\InvoicePaid;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Photon\Domains\Data\Jobs\FindObjectByIDJob;
use Photon\Domains\Http\Jobs\JsonResponseJob;
use Photon\Foundation\Feature;
use Photon\Foundation\Exceptions\Exception;
use Photon\Foundation\Http\Request;

/**
 * Class InvoicePayFeature
 * @package App\Features\Invoices
 */
class InvoicePayFeature extends Feature
{

    /**
     * @var int
     */
    private $invoiceId;

    /**
     * InvoicePayFeature constructor.
     * @param int $invoiceId
     */
    function __construct(int $invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    /**
     *
     */
    function handle(Request $request)
    {
        $status = ( $request->get('status') ) ? $request->get('status') : 'P';

        $invoice = $this->run(FindObjectByIDJob::class,[
            'model' => Invoice::class,
            'objectID' => $this->invoiceId
        ]);

        if( !$invoice ){
            throw new ModelNotFoundException();
        }

        $invoice->Load('tenant','landlord');

        if( $invoice->status == $status ){
            throw new Exception('Invoice is already in that status.');
        }
        else if( $invoice->paid ){
            throw new Exception('Invoice is already paid.');
        }
        $invoice->status = $status;
        $invoice->paid = true;

        $this->run(UpdateInvoiceJob::class,[
            'invoice' => $invoice
        ]);

        $landlord = $invoice->landlord;

        $tenant = $invoice->tenant;

        $landlord->notify(new InvoicePaid($tenant, $invoice->invoice_no));

        $push = [
            'event' => 'INVOICE_PAID',
            'landlord' => $landlord->id,
            'name' => $tenant->name,
            'invoice_no' => $invoice->invoice_no
        ];
        event(new InvoiceEvent($push));
        /*notify the user*/

        return $this->run(new JsonResponseJob($invoice));
    }
}
