<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Providers\ProvisionTracker\Api\UserService;

class UserServiceTest extends TestCase
{
    public function __construct() {
        $this->userService = new UserService();
    }

    /**
     * [testGetSuperUsers description]
     * @return [type] [description]
     */
    public function testGetSuperUsers()
    {
        $type = 1;
        $users = $this->userService->getUsers( $type );
        $this->assertInstanceOf( Illuminate\Database\Eloquent\Collection::class, $users);
    }

    /**
     * [testGetUsers description]
     * @return [type] [description]
     */
    public function testGetUsers()
    {
        $users = $this->userService->getUsers();
        $this->assertInstanceOf( Illuminate\Database\Eloquent\Collection::class, $users);

        $super_users = $this->userService->getUsers(1);
        $this->assertInstanceOf( Illuminate\Database\Eloquent\Collection::class, $super_users);
        $this->assertGreaterThan( 0, count($super_users));

        // get users for the first account
        $users_for_account = $this->userService->getUsers(null, 2);
        $this->assertInstanceOf( Illuminate\Database\Eloquent\Collection::class, $users_for_account);
        $this->assertGreaterThan( 0, count($users_for_account));
    }

    /**
     * [testCreateAndDestroyUser description]
     * @return [type] [description]
     */
    public function testCreateAndDestroyUser()
    {
        // Check user doesn't exisit
        $nonExistinguser = $this->userService->getUser("provisiontracker@gmail.com");
        $this->assertNull( $nonExistinguser);

        // Create one and check it was added to the db
        $user = $this->userService->createUser(2, 1234567);
        $user->first_name = "Simon";
        $user->last_name = "Hamilton";
        $user->email = "provisiontracker@gmail.com";
        $user->password = "Gn0c3c";
        $saved = $user->save();
        $this->assertTrue($saved);

        // Check the user was added to the db
        $savedUser = $this->userService->getUser("provisiontracker@gmail.com");
        $this->assertEquals( $savedUser->email, "provisiontracker@gmail.com");

        // Delete the user and check it doesn't exist
        $this->userService->deleteUser("provisiontracker@gmail.com");
        $nonExistinguser = $this->userService->getUser("provisiontracker@gmail.com");
        $this->assertNull( $nonExistinguser);
    }
}
