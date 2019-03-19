<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/19/2019
 * Time: 12:21 AM
 */

namespace App\Domains\Invoices\Jobs;


use App\Data\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use Photon\Foundation\Job;

class LoadInvoicesByCriteriaJob extends Job
{
    private $criteria;
    private $relations;
    function __construct(array $criteria, $relations = null)
    {
        $this->criteria = $criteria;
        $this->relations = $relations;
    }

    function handle( ):Collection
    {
        $invoices =  Invoice::where($this->criteria);

        if( $this->relations ){
            $invoices = $invoices->with($this->relations);
        }

        return $invoices->get();

    }
}
