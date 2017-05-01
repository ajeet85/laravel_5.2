<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Controllers\Controller;
use App\Providers\ProvisionTracker\Api\UserServiceInterface;
use App\Providers\ProvisionTracker\Api\OrganisationServiceInterface;
use App\Providers\ProvisionTracker\UtilsServiceInterface;
use Carbon\Carbon;

class UserController extends Controller
{
    //
    public function __construct(UserServiceInterface $userService,
    	OrganisationServiceInterface $orgService,
        UtilsServiceInterface $utilsService
        ){
        $this->userService = $userService;
        $this->orgService = $orgService;
        $this->utilsService = $utilsService;
    }

    public function view(){
    	$data = [];
    	return \View::make('app.profile.view', $data);
    }

    public function update(UserRequest $request){
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
       
        $user_id = $request->input('id');
        $updated = $this->userService->updateUsers( $user_id,$first_name,$last_name );
        return ($updated) ? 'Profile Updated' : 'Profile can\'t be updated'; 
    }

    public function changePassword(){
        return \View::make('app.profile.sections.update-password');
    }


    public function editPassword(PasswordRequest $request){
        $new_password = $request->input('password');
        $user_id = $request->input('id');
        $password = \Hash::make( $new_password );
        $confirmation_code = uniqid();
        $user_details = $this->userService->getUser( null,$user_id,null );
        $request_change_password = $this->userService->updateInfo( $confirmation_code,$user_details,'Update Password',$password );
        return ($request_change_password) ? 'Please Login to your Registerd Email Account to Verify you want to Change Password' : 'Can\'t Change Password';
       
    }

    public function changeEmail(){
         return \View::make('app.profile.sections.update-email');
    }

    public function editEmail(Request $request){
        $email = $request->input('email');
        $user_id = $request->input('id');
        $confirmation_code = uniqid();
        $user_details = $this->userService->getUser( null,$user_id,null );
        $request_change_email = $this->userService->updateInfo( $confirmation_code,$user_details,'Update Email',$email );
        return ($request_change_email) ? 'Please Login to your Registerd Email Account to Verify you want to Change Email' : 'Can\'t Change Email';
    }

    public function updatePassword(Request $request){
        $code = \Request::segment(4);
        $details = $this->userService->getUserActionDetails( $code );
        $today_date = Carbon::now();
        $is_link_valid = $this->utilsService->compareDate( $today_date, $details->expiry_date );
        if($is_link_valid){
            $update_password =  $this->userService->updateUsers( $details->user_id,null,null,$details->value );
            $this->userService->updateUserActionDetails( $details->id );
            return ($update_password) ? 'Password Updated' : 'Password can\'t be updated';
        }
        else{
            return 'Your Password Updation Link expired.Change Your Password again';
        }
    }

    public function updateEmail(Request $request){
        $code = \Request::segment(4);
        $details = $this->userService->getUserActionDetails( $code );
        $today_date = Carbon::now();
        $is_link_valid = $this->utilsService->compareDate( $today_date, $details->expiry_date );
        if($is_link_valid){
            $update_email =  $this->userService->updateUsers(  $details->user_id,null,null,$details->value,null );
            $this->userService->updateUserActionDetails( $details->id );
            return ($update_email) ? 'Email Updated' : 'Email can\'t be updated';
        }
        else{
            return 'Your Email Updation Link expired.Change Your Password again';
        }

    }


}
