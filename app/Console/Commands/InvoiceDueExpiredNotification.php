<?php

namespace App\Console\Commands;

use App\Features\Invoices\InvoiceDueExpiredFeature;
use Illuminate\Console\Command;

class InvoiceDueExpiredNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to user about invoice due date expired.';

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
        $invoiceDueExpiredFeature = new InvoiceDueExpiredFeature();
        $invoiceDueExpiredFeature->handle();
    }
}
