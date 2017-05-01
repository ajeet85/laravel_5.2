<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Jobs\EventRunner;

class NotificationController extends Controller
{
    public function __construct( AccountServiceInterface $accountService ) {
        $this->accountService = $accountService;
    }

    public function index() {

    }

    public function action( $code ) {
        $action = $this->accountService->getAccountAction( $code );
        // Only fire this event if it hasn't already been executed
        if( $action->status != 'actioned' ) {
            // This triggers a long process, so add it
            // to the queue so the user can continue
            // $event = new $action->event( $code );
            $job = new EventRunner( $action->event, $code );
            $this->dispatch( $job );
        }
    }
}
