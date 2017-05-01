<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Providers\ProvisionTracker\Api\AccountService;
use App\Providers\ProvisionTracker\Api\PackageService;
use App\Providers\ProvisionTracker\Api\RegistrationService;
use App\Providers\ProvisionTracker\Api\UserService;

class AccountServiceTest extends TestCase
{
    public function __construct() {
        $this->accountService = new AccountService();
        $this->packageService = new PackageService();
        $this->registrationService = new PackageService();
        $this->userService = new UserService();
    }

    /**
     * [testAccountCreation description]
     * @return [type] [description]
     */
    public function testAccountCreation() {
        // Check account doesn't exisit
        $nonExistingAccount = $this->accountService->getAccount(1234567);
        $this->assertNull( $nonExistingAccount);

        // Create package, account and fake manager
        $packageGroup1        = $this->packageService->getPackageGroup(1);
        $group1Packages       = $this->packageService->getPackages($packageGroup1);
        $aPackage             = $this->packageService->getPackage($group1Packages->first()->id);
        $account = $this->accountService->createAccount( 1234567 );
        $account->package_id = $aPackage->id;
        $account->manager_id = 1;
        $account->save();

        $this->assertInstanceOf(App\Models\Account::class, $account);
        $this->assertEquals( $account->status, 'unconfirmed');

        // Test confirmation of this account
        $fake_code = 'Ghj6!PD';
        $this->accountService->addAccountAction($account->id, 'confirm', 'pending', $fake_code );
        $action_id = $this->accountService->getActionId( $fake_code );
        $confirmed = $this->accountService->confirmAccount( $action_id, $account->id );
        $this->assertEquals( $confirmed, 'confirmed');
        // If confirmation is triggered again,
        // check that the right response is returned
        $lareadyConfirmed = $this->accountService->confirmAccount( $action_id, $account->id );
        $this->assertEquals( $lareadyConfirmed, 'registered');

        // Remove the action and check it doesn't exist
        $this->accountService->removeAction( $action_id, $account->id );

        // Remove the account and check it doesn't exist
        $this->accountService->removeAccount( null, 1234567);
        $removedAccount = $this->accountService->getAccount(1234567);
        $this->assertNull( $removedAccount);
    }

    /**
     * [testGetAccounts description]
     * @return [type] [description]
     */
    public function testGetAccounts() {
        $accounts = $this->accountService->getAccounts();
        $this->assertInstanceOf( Illuminate\Database\Eloquent\Collection::class, $accounts);

        $active_accounts = $this->accountService->getAccounts(null, 'active');
        $this->assertInstanceOf( Illuminate\Database\Eloquent\Collection::class, $active_accounts);

        $user = $this->userService->getUser(null, 1);
        $active_accounts_for_user = $this->accountService->getAccounts($user, 'active');
        $this->assertInstanceOf( Illuminate\Database\Eloquent\Collection::class, $active_accounts_for_user);
    }

    /**
     * [testHasMultipleAccounts description]
     * @return [type] [description]
     */
    public function testHasMultipleAccounts() {
        // The Db seeder sets the first user for multiple accounts.
        // We can use that account here for testing
        $user = $this->userService->getUser(null, 1);
        $hasMultipleAccounts = $this->accountService->hasMultipleAccounts($user);
        $this->assertTrue( $hasMultipleAccounts);
    }

    /**
     * [testAccountActionViews description]
     * @return [type] [description]
     */
    public function testAccountActionViews() {
        $confirmed = $this->accountService->getAccountActionView( 'confirmed');
        $this->assertEquals( $confirmed, 'registration.confirmed');

        $registered = $this->accountService->getAccountActionView( 'registered');
        $this->assertEquals( $registered, 'registration.registered');

        $notFound = $this->accountService->getAccountActionView( '404');
        $this->assertEquals( $notFound, 'registration.404');
    }

    /**
     * [testAccountActions description]
     * @return [type] [description]
     */
    public function testAccountActions() {
        $fake_code = 'Ghj6!PD';
        // Check our account action doesn't exist
        $non_existing_action = $this->accountService->getAccountAction($fake_code);
        $this->assertNull( $non_existing_action );

        // Make the action and check it exists
        $this->accountService->addAccountAction(1, 'confirm', 'pending', $fake_code );
        $action = $this->accountService->getAccountAction($fake_code);
        $this->assertNotNull( $action );

        // Check status updates
        $this->accountService->updateActionStatus( $action->id, 'pending');
        $action = $this->accountService->getAccountAction($fake_code);
        $this->assertEquals( $action->status, "pending");

        // Check the action id
        $action_id = $this->accountService->getActionId( $fake_code );
        $this->assertEquals( $action_id, $action->id);

        // Check the action type
        $action_type = $this->accountService->getActionType( $fake_code );
        $this->assertEquals( $action_type, "confirm");

        // Check we can get the account id from the action
        $account_id = $this->accountService->getActionAccountId( $fake_code );
        $this->assertEquals( $account_id, 1);

        // Remove the action and check it doesn't exist
        $this->accountService->removeAction( $action->id, 1 );
        $non_existing_action = $this->accountService->getAccountAction($fake_code);
        $this->assertNull( $non_existing_action );

        // Check that after removal the action returns the right value
        $account_id = $this->accountService->getActionAccountId( $fake_code );
        $this->assertEquals( $account_id, -1);

        $action_type = $this->accountService->getActionType( $fake_code );
        $this->assertEquals( $action_type, 'not-found');

        $action_id = $this->accountService->getActionId( $fake_code );
        $this->assertEquals( $action_id, -1);
    }

}
