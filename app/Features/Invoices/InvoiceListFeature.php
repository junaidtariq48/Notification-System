<?php

namespace App\Features\Invoices;

use App\Data\Models\Invoice;
use Photon\Foundation\Feature;
use Photon\Domains\Data\Jobs\BuildEloquentQueryFromRequestJob;

/**
 * Class InvoicePayFeature
 * @package App\Features\Invoices
 */
class InvoiceListFeature extends Feature
{

    /**
     * @return mixed
     */
    function handle()
    {
        return $this->run(BuildEloquentQueryFromRequestJob::class, ['model' => Invoice::class]);
    }
}
