<?php

namespace App\Providers\ProvisionTracker\Api;
use App\User;
use App\Models\Account;

interface AccountServiceInterface
{
    // get accounts for user
    // get all accounts
    // get all active active accounts
    // create new account

    public function getAccount( $id=null, $pt_id=null );
    public function getAccounts( User $user=null, $status=null );
    public function getAccountsAsOptions( User $user=null );
    public function createAccount( $pt_id );
    public function removeAccount( $id, $pt_id );
    public function confirmAccount( $action_id, $account_id );
    public function getActionType( $action_code );
    public function getActionId( $action_code );
    public function getActionAccountId( $action_code );
    public function getAccountActionView( $action );
    public function addAccountAction( $account_id, $action, $status, $action_code, $event=null);
    public function createRelationship( $account_id, $user, $type_id );
    public function hasMultipleAccounts( User $user );
    public function removeAction( $action_id, $account_id );
    public function updateActionStatus( $action_id, $status );
    public function isAccountNameUnique( $name );
    public function decrementTrialDays( $days );
    public function decrementPackageDays( $days );
    public function setAccountStatus( $account, $status );
    public function updateRenewalDate( $account_id, $new_date );
    public function resetPackageDays( $account_id, $days );
    public function setRenewedState( $account_id, $state );
}
