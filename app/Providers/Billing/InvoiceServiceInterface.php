<?php

namespace App\Providers\Billing;
use App\User;
use App\Models\Invoice;

interface InvoiceServiceInterface
{
    public function raiseInvoice( $account );
    public function getInvoices( $account_id );
    public function getInvoice( $invoice_number, $account_id );
    public function getInvoiceItems( $invoice_id );
}
