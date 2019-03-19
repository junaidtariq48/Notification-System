<?php

namespace App\Console\Commands;

use App\Features\Invoices\InvoiceDueFeature;
use Illuminate\Console\Command;

class InvoiceDueNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send user notification that invoice is due.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $invoiceDueFeature = new InvoiceDueFeature();
        $invoiceDueFeature->handle();
    }
}
