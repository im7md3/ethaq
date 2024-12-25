<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Service\Tamam;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateTamamInvoiceStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TamamInvoices:update_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send report delivery to tamam after 24H';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $twentyFourHoursAgo = Carbon::now()->subHours(24);

        // Get all invoices with "tamam_success" older than 24 hours and status not already "Paid"
        $invoicesToUpdate = Invoice::where('status', '!=', 'paid')
            ->where('tamam_success', '<=', $twentyFourHoursAgo)
            ->get();

        foreach ($invoicesToUpdate as $invoice) {
            $response = Tamam::CheckTransactionStatus($invoice->tamam_transaction_id);
            if ($response and $response->response->transaction_status == "Loan Application completed successfully by Client, Pending delivery") {
                $responseDelivery = Tamam::ReportDelivery($invoice);
                if ($responseDelivery->meta->status_code == "TM200") {
                    $invoice->update(['status' => 'paid']);
                }
            }
        }
    }
}
