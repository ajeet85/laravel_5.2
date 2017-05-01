<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use Illuminate\Http\Request;

class BaseComposer
{

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(OrganisationServiceInterface $orgService,
                                AccountServiceInterface $accountService,
                                Request $request)
    {
        $this->accountService = $accountService;
        $this->orgService = $orgService;
        $this->request = $request;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $authUser = \Auth::user();
        $authUser->first_name = ucfirst($authUser->first_name);
        $authUser->last_name = ucfirst($authUser->last_name);
        $accounts = $this->accountService->getAccounts( $authUser, 'active');
        $current_account_id = $this->request->session()->get('account');
        $current_organisation_id = $this->request->session()->get('organisation');
        $account = $this->accountService->getAccount($current_account_id);
        $organisations = $this->orgService->getOrganisations($current_account_id);
        $current_org = $this->orgService->getOrganisation($current_organisation_id);
        $current_path = $this->request->path();
        $orgs_as_options = $this->orgService->getOrganisationsAsOptions($current_account_id);
        $accs_as_options = $this->accountService->getAccountsAsOptions($authUser);

        $view->with('accounts', $accounts);
        $view->with('organisations', $organisations);
        $view->with('org_account', $account);
        $view->with('orgs_as_options', $orgs_as_options);
        $view->with('accs_as_options', $accs_as_options);
        $view->with('current_path', "/$current_path");
        $view->with('current_org_id', $current_organisation_id);
        $view->with('current_org', $current_org);
        $view->with('current_account_id', $current_account_id);
        $view->with('current_user', $authUser);

        // Pass in current nav paths for highlighting
        $view->with('current_root_item', $this->request->segment(2) );
        $view->with('current_child_item', $this->request->segment(5) );
    }
}
