<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/17/2019
 * Time: 2:32 AM
 */

namespace App\Http\Controllers;

use App\Features\Invoices\InvoiceDueExpiredFeature;
use App\Features\Invoices\InvoiceDueFeature;
use App\Features\Invoices\InvoiceListFeature;
use App\Features\Invoices\InvoicePayFeature;
use Photon\Foundation\Controller;

class InvoicesController extends Controller
{

    public function index()
    {
        return $this->serve(InvoiceListFeature::class);
    }

    public function invoicePay(int $id)
    {
        return $this->serve(InvoicePayFeature::class, [
            'invoiceId' => $id
        ]);
    }

}
