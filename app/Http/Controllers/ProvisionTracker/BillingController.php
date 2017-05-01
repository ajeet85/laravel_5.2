<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Providers\Billing\InvoiceServiceInterface;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use Knp\Snappy\Pdf;

class BillingController extends Controller
{
    public function __construct( InvoiceServiceInterface $invoiceService,
                                 UtilsServiceInterface $utilsService) {
        $this->invoiceService = $invoiceService;
        $this->utilsService = $utilsService;
    }

    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index( Request $request) {
        $page = $request->input('page', 1);
        $account_id = $request->session()->get('account');
        $invoices = $this->invoiceService->getInvoices( $account_id );
        $data['invoices'] = $this->utilsService->dopagination( $invoices, 15 );
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('billing/index', function($breadcrumbs) use ($route_params) {
            $breadcrumbs->push('Settings', route('settings/index'));
            $breadcrumbs->push('Billing');
        });
        // ------------------------------------------
        return \View::make('app.billing.index', $data);
    }

    /**
     * [invoice description]
     * @param  Request $request        [description]
     * @param  [type]  $invoice_number [description]
     * @return [type]                  [description]
     */
    public function invoice( Request $request, $invoice_number ) {
        $account_id = $request->session()->get('account');
        $data = [];
        $invoice = $this->invoiceService->getInvoice( $invoice_number, $account_id );
        $data['invoice'] = $invoice;
        $data['invoice_items'] = $this->invoiceService->getInvoiceItems( $invoice->id );
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('billing/invoice', function($breadcrumbs) use ($route_params, $invoice) {
            $breadcrumbs->push('Settings', route('settings/index'));
            $breadcrumbs->push('Billing', route('billing/index'));
            $breadcrumbs->push("Invoice: $invoice->invoice_number");
        });
        // ------------------------------------------
        return \View::make('app.billing.invoice', $data);
    }

    /**
     * [print description]
     * @param  Request $request        [description]
     * @param  [type]  $invoice_number [description]
     * @return [type]                  [description]
     */
    public function printInvoice( Request $request, $invoice_number ) {
        $account_id = $request->session()->get('account');
        $data = [];
        $invoice = $this->invoiceService->getInvoice( $invoice_number, $account_id );
        $data['invoice'] = $invoice;
        $data['invoice_items'] = $this->invoiceService->getInvoiceItems( $invoice->id );
        $pdf = \View::make('app.billing.invoice-printable', $data);
        $snappy = new Pdf( base_path("vendor/bin/wkhtmltopdf-amd64") );
        $snappy->generateFromHtml($pdf, base_path("storage/test.pdf") );
    }

}
