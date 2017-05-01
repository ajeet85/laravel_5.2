<?php

namespace App\Providers\Billing;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Providers\ProvisionTracker\Api\PackageServiceInterface;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use Carbon\Carbon;
use Knp\Snappy\Pdf;

class InvoiceService implements InvoiceServiceInterface
{
    public function __construct( AccountServiceInterface $accountService,
                                 PackageServiceInterface $packageService,
                                 UniqueIdServiceInterface $idService ) {
        $this->accountService = $accountService;
        $this->packageService = $packageService;
        $this->idService = $idService;
    }

    /**
     * [getInvoice description]
     * @param  [type] $invoice_number [description]
     * @param  [type] $account_id     [description]
     * @return [type]                 [description]
     */
    public function getInvoice( $invoice_number, $account_id ) {
        $query = [];
        $query[] = ['account_id', $account_id];
        $query[] = ['invoice_number', $invoice_number];
        $invoice = Invoice::where( $query )->get()->first();
        return $invoice;
    }

    /**
     * [getInvoices description]
     * @param  [type] $account [description]
     * @return [type]          [description]
     */
    public function getInvoices( $account_id ) {
        $query = [];
        $query[] = ['account_id', $account_id];
        $invoices = Invoice::where( $query );
        return $invoices;
    }

    /**
     * [getInvoiceItems description]
     * @param  [type] $invoice_id [description]
     * @return [type]             [description]
     */
    public function getInvoiceItems( $invoice_id ) {
        $query = [];
        $query[] = ['invoice_id', $invoice_id];
        $invoice_items = InvoiceItem::where( $query )->get();
        return $invoice_items;
    }

    /**
     * [raiseInvoice description]
     * @param  [type] $account [description]
     * @return [type]          [description]
     */
    public function raiseInvoice( $account ) {
        // What package is this account on
        $package = $this->packageService->getPackage( $account->package_id );
        // Get the number of times this account has been invoiced
        // so we can get the right things to invoice for
        $invoices_for_account = $this->getInvoices( $account->id )->get();
        $total_invoices = count($invoices_for_account);
        // Get the things we need to invoice
        $package_fees = $this->getPackageFees( $total_invoices );

        // Raise an invoice containing the
        // basic invoice details
        $invoice = new Invoice();
        $invoice->purchase_order = "unknown";
        $invoice->invoice_number = $this->idService->ptId();
        $invoice->due_date = Carbon::now()->addDays(14);
        $invoice->paid = 0;
        $invoice->account_id = $account->id;
        $invoice->save();

        $invoice_net_total = 0;
        $invoice_vat_total = 0;
        $invoice_gross_total = 0;

        foreach( $package_fees as $package_fee ) {
            $quantity = 1;
            // Set the invoice item costs
            $unit_price = $package[$package_fee->table_column];
            $net_total = $unit_price * $quantity;
            $gross_total = $net_total * 1.20;
            $vat_difference = $gross_total - $net_total;

            // Update the containing invoice totals
            $invoice_net_total+= $net_total;
            $invoice_vat_total+= $vat_difference;
            $invoice_gross_total+= $gross_total;

            // Create the invoice item
            $invoice_item = new InvoiceItem();
            $invoice_item->quantity = $quantity;
            $invoice_item->description = $package_fee->label;
            $invoice_item->unit_price = $unit_price;
            $invoice_item->vat = 20;
            $invoice_item->net_total = $net_total;
            $invoice_item->gross_total = $gross_total;
            $invoice_item->invoice_id = $invoice->id;
            $invoice_item->save();
        }

        // Set the final costs for the containing invoice
        $invoice->net_total = $invoice_net_total;
        $invoice->vat = $invoice_vat_total;
        $invoice->gross_total = $invoice_gross_total;
        $invoice->save();

        return $invoice;
    }

    /**
     * [createInvoicePdf description]
     * @param  [type] $invoice_number [description]
     * @param  [type] $account_id     [description]
     * @return [type]                 [description]
     */
    public function createInvoicePdf( $invoice_number, $account_id ) {
        $invoice = $this->getInvoice( $invoice_number, $account_id );
        $data['invoice'] = $invoice;
        $data['invoice_items'] = $this->getInvoiceItems( $invoice->id );
        $filename = base_path("storage/$invoice_number"."_$account_id.pdf");
        $invoice->file_location = $filename;
        $invoice->save();
        $pdf = \View::make('app.billing.invoice-printable', $data);
        $snappy = new Pdf( base_path("vendor/bin/wkhtmltopdf-amd64") );
        $snappy->generateFromHtml($pdf, $filename );
        
        return $filename;
    }

    /**
     * [getPackageFees description]
     * @param  [type] $total_invoices [description]
     * @return [type]                 [description]
     */
    private function getPackageFees( $total_invoices ) {
        if( $total_invoices < 1 ) {
            // Get all planned charges
            // including the off setup cost
            return $this->packageService->getPackageFees();
        }

        if( $total_invoices >= 1 ) {
            return $this->packageService->getPackageFees('yearly');
        }
    }
}
