<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Providers\ProvisionTracker\Api\UserServiceInterface;
use App\Models\SuperUser;
use App\Models\Account;
use App\Models\Package;
use App\Events\UserWasRegistered;

class RegistrationService implements RegistrationServiceInterface
{
    public function __construct( UniqueIdServiceInterface $idService,
                                 AccountServiceInterface $accountService,
                                 UserServiceInterface $userService) {
        $this->idService = $idService;
        $this->accountService = $accountService;
        $this->userService = $userService;
    }

    /**
     * Create the confirm action in the table.
     * Send the email to the customer
     * and wait for the response
     * @return [type] [description]
     */
    public function submit( $registration ) {
        // Check to see if user exists first
        $userExists = $this->userService->getUser( $registration['manager']->email );

        if( $userExists ) {
            return response()->view('registration.duplicate');
        }

        if( ! $userExists ) {
            $registration['activation_code'] = $this->idService->ptId();
            $registration['confirmation_link'] = $this->getConfirmationLink( $registration['activation_code'] );

            $this->updateAccountAndUser( $registration );
            $this->addPendingAccount( $registration );

            \Event::fire( new UserWasRegistered($registration) );
            return response()->view('registration.pending');
        }
    }

    public function confirmRegistration( $confirmation_code ) {

    }

    /**
     * [createAccountname description]
     * @return [type] [description]
     */
    public function createAccountname() {
        return $this->idService->ptId();
    }

    /**
     * [getRegistrationAssets description]
     * @return [type] [description]
     */
    public function getRegistrationAssets( Package $package ) {
        $data = [];
        $data['manager'] = $this->userService->createUser( 1, $this->idService->ptId() );
        $data['account'] = $this->accountService->createAccount( $this->idService->ptId() );
        // Give the account the right details
        // so it can be saved and is ready for confirmation
        $data['account']->package_id = $package->id;
        return $data;
    }

    /**
     * [getConfirmationLink description]
     * @param  [type] $confirm_code [description]
     * @return [type]               [description]
     */
    private function getConfirmationLink( $confirm_code ) {
        return \Request::root() . "/action/confirm/account/$confirm_code";
    }

    /**
     * [addPendingAccount description]
     * @param [type] $registration [description]
     */
    private function addPendingAccount( $registration ) {
        $this->accountService->addAccountAction($registration['account']->id, 'confirm', 'pending', $registration['activation_code']);
    }

    /**
     * [updateAccountAndUser description]
     * @param  [type] $registration [description]
     * @return [type]               [description]
     */
    private function updateAccountAndUser( $registration ) {
        $registration['manager']->password = \Hash::make( $registration['manager']->password );
        $registration['manager']->save();
        $registration['account']->manager_id = $registration['manager']->id;
        $registration['account']->save();
        $this->accountService->createRelationship( $registration['account']->id, $registration['manager'], 1);

    }
}
