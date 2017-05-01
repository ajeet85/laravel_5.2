<?php

namespace App\Providers\ProvisionTracker\Api;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Account;
use App\User;
use App\Models\UserAccountRelationship;
use Carbon\Carbon;
use App\Events\RegistrationWasConfirmed;
use App\Events\TrialPeriodHasFinished;
use App\Events\PackageSubscriptionHasFinished;

class AccountService implements AccountServiceInterface
{

    /**
     * [perfomAccountAction description]
     * @param  [type] $action [description]
     * @return [type]         [description]
     */
    public function confirmAccount( $action_id, $account_id ) {
        $query = [];
        $query[] = ['id', $account_id];
        $account = Account::where( $query )->get()->first();
        // The account id is retrieved via the accounts_action table.
        // If the account id is not present in this table, then we know
        // the action has happend see: $this->getActionAccountId
        if( ! $account  ) {
            return '404';
        }

        if( $account->status == 'unconfirmed' ) {
            $account->status = 'trial';
            $state = $account->save();
            $this->updateActionStatus( $action_id, 'actioned' );

            \Event::fire( new RegistrationWasConfirmed( $account ) );
            return 'confirmed';
        }
        else if( $account->status == 'active' ) {
            return 'registered';
        }
    }

    /**
     * [resetPackageDays description]
     * @param [type] $account_id [description]
     * @param [type] $days       [description]
     */
    public function resetPackageDays( $account_id, $days ) {
        $account = $this->getAccount( $account_id );
        $account->days_left = $days;
        $account->save();
    }

    /**
     * [decrementTrialDays description]
     * @param  [type] $days [description]
     * @return [type]       [description]
     */
    public function decrementTrialDays( $days ) {
        $rows = $this->getAccounts( null, 'trial' );
        $this->checkRemainingDays( $rows, $days, 'App\Events\TrialPeriodHasFinished' );
    }

    /**
     * [decrementPackageDays description]
     * @param  [type] $days [description]
     * @return [type]       [description]
     */
    public function decrementPackageDays( $days ) {
        $rows = $this->getAccounts( null, 'active' );
        $this->checkRemainingDays( $rows, $days, 'App\Events\PackageSubscriptionHasFinished' );
    }

    /**
     * [checkRemainingDays description]
     * @param  [type] $rows  [description]
     * @param  [type] $event [description]
     * @return [type]        [description]
     */
    private function checkRemainingDays( $rows, $days, $event ) {
        foreach ($rows as $row ) {
            $account = $this->getAccount( $row->id );
            $days_left = $account->days_left - $days;
            $account->days_left = $days_left;
            $account->save();
            // When we reach 0, update the status
            // and let the system know this account's
            // trial period has finished
            if( $days_left == 0) {
                $this->setAccountStatus( $account, 'locked');
                \Event::fire( new $event( $account ) );
            }
        }
    }

    /**
     * [getAccountActionView description]
     * @param  [type] $action [description]
     * @return [type]         [description]
     */
    public function getAccountActionView( $action ) {
        switch ( $action ) {
            case 'confirmed':
                return 'registration.confirmed';
                break;
            case 'registered':
                return 'registration.registered';
                break;
            case '404':
                return 'registration.404';
                break;
            default:
                break;
        }
    }

    /**
     * [getActionId description]
     * @param  [type] $action_code [description]
     * @return [type]              [description]
     */
    public function getActionId( $action_code ) {
        try {
            $query[] = ['code', $action_code];
            $query[] = ['status', 'pending'];
            $id = \DB::table('account_actions')->where($query)->get()[0]->id;
        } catch ( \ErrorException $e ) {
            // If no id is found, it means the
            // action has already happened.
            $id = -1;
        }

        return $id;
    }

    /**
     * [findTask description]
     * @param  [type] $action [description]
     * @return [type]         [description]
     */
    public function getActionType( $action_code ) {
        try {
            $query[] = ['code', $action_code];
            $query[] = ['status', 'pending'];
            $code = \DB::table('account_actions')->where($query)->get()[0]->action;
        } catch ( \ErrorException $e ) {
            // If no code is found, it means the
            // action has already happened.
            $code = 'not-found';
        }
        return $code;
    }

    /**
     * [getActionAccount description]
     * @param  [type] $action [description]
     * @return [type]         [description]
     */
    public function getActionAccountId( $action_code ) {
        try {
            $query[] = ['code', $action_code];
            // Accounts may have been activated, so also
            // check to see if the task has been completed already
            $account_id = \DB::table('account_actions')->where($query)
                            ->where(function($query){
                                $query
                                ->orWhere('status', '=', 'pending')
                                ->orWhere('status', '=', 'actioned');})
                            ->get()[0]->account_id;
        } catch ( \ErrorException $e  ) {
            $account_id = -1;
        }
        return $account_id;
    }

    /**
     * [createAccount description]
     * @param  [type] $pt_id [description]
     * @return [type]        [description]
     */
    public function createAccount( $pt_id ) {
        $account = factory(Account::class)->make([
            'pt_id'         => $pt_id,
            'status'        => 'unconfirmed',
            'name'          => '',
            'slug'          => '',
            'renewal_date'  => null,
            'package_id'    => null,
            'manager_id'    => null,
        ]);
        return $account;
    }

    /**
     * [setAccountStatus description]
     * @param [type] $status [description]
     */
    public function setAccountStatus( $account, $status ) {
        $account->status = $status;
        $account->save();
    }

    /**
     * [isAccountNameUnique description]
     * @return boolean [description]
     */
    public function isAccountNameUnique( $name ) {
        $account = Account::where('name', '=', $name )->get();
        return (count($account) > 0) ? false : true;
    }

    /**
     * [updateRenewalDate description]
     * @return [type] [description]
     */
    public function updateRenewalDate( $account_id, $new_date ) {
        $account = $this->getAccount($account_id);
        $account->renewal_date = $new_date;
        $account->save();
    }

    /**
     * [setRenewedState description]
     * @param [type] $account_id [description]
     * @param [type] $state      [description]
     */
    public function setRenewedState( $account_id, $state ) {
        $account = $this->getAccount($account_id);
        $account->renewed = $state;
        $account->save();
    }

    /**
     * [removeAccount description]
     * @param  [type] $id    [description]
     * @param  [type] $pt_id [description]
     * @return [type]        [description]
     */
    public function removeAccount( $id, $pt_id ) {
        $query = [];
        if( $id ) {
            $query[] = ['id', $id];
        }

        if( $pt_id ) {
            $query[] = ['pt_id', $pt_id];
        }
        return Account::where( $query )->delete();
    }

    /**
     * [getAccount description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getAccount( $id=null, $pt_id=null ) {
        $query = [];
        if( $id ) {
            $query[] = ['id', $id];
        }

        if( $pt_id ) {
            $query[] = ['pt_id', $pt_id];
        }
        return Account::where( $query )->get()->first();
    }

    /**
     * Get all accounts and filter by user or status if needed
     * @param  [User Object] $user
     * @param  [String] $status
     * @return [DB result Array]
     */
    public function getAccounts( User $user=null, $status=null ) {
        $query = [];

        if( $user ) {
            $query[] = ['user_id', $user->id];
        }

        if( $status ) {
            $query[] = ['status', $status];
        }

        $accounts = \DB::table('users_accounts')
            ->join('accounts', 'users_accounts.account_id', '=', 'accounts.id')
            ->join('users', 'users_accounts.user_id', '=', 'users.id')
            ->select('accounts.id', 'accounts.name', 'users_accounts.user_id', 'users.first_name')
            ->where( $query )
            ->get();

        return new Collection( $accounts );
    }

    /**
     * [getAccountsAsOptions description]
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function getAccountsAsOptions( User $user=null ) {
        $accounts = $this->getAccounts( $user );
        $options = [];
        foreach ($accounts as $account ) {
            $option = new \stdClass();
            $option->value = $account->id;
            $option->name = $account->name;
            $options[] = $option;
        }
        return $options;
    }

    /**
     * [hasMultipleAccounts description]
     * @param  User    $user [description]
     * @return boolean       [description]
     */
    public function hasMultipleAccounts( User $user ) {
        $accounts = $this->getAccounts( $user, 'active' );
        return ( count($accounts) > 1) ? true:false;
    }

    /**
     * [addAccountAction description]
     * @param [type] $account_id  [description]
     * @param [type] $action      [description]
     * @param [type] $status      [description]
     * @param [type] $action_code [description]
     */
    public function addAccountAction( $account_id, $action, $status, $action_code, $event=null) {
        \DB::table('account_actions')->insert([
            'account_id'    => $account_id,
            'action'        => $action,
            'status'        => $status,
            'code'          => $action_code,
            'event'         => $event,
            'expiry_date'   => Carbon::now()->addMonth()
        ]);
    }

    /**
     * [getAccountAction description]
     * @param  [type] $action_code [description]
     * @return [type]              [description]
     */
    public function getAccountAction( $action_code ) {
        $action = \DB::table('account_actions')->where('code', '=', $action_code)->get();
        if( count($action) > 0 ) {
            return $action[0];
        } else {
            return null;
        }
    }

    /**
     * [createRelationship description]
     * @param  [type] $account_id [description]
     * @param  [type] $user       [description]
     * @return [type]             [description]
     */
    public function createRelationship( $account_id, $user, $type_id ) {
        $relationship = new UserAccountRelationship();
        $relationship->account_id = $account_id;
        $relationship->user_id = $user->id;
        $relationship->type_id = $type_id;
        $relationship->save();
    }

    /**
     * [removeAction description]
     * @return [type] [description]
     */
    public function removeAction( $action_id, $account_id ) {
        $query[] = ['id', $action_id];
        $query[] = ['account_id', $account_id];
        return \DB::table('account_actions')->where($query)->delete();
    }

    /**
     * [updateActionStatus description]
     * @return [type] [description]
     */
    public function updateActionStatus( $action_id, $status ) {
        $query[] = ['id', $action_id];
        \DB::table('account_actions')->where($query)->update(['status'=> $status]);
    }
}
