<?php

namespace App\Providers\ProvisionTracker\Api;
use App\Models\SuperUser;
use Illuminate\Database\Eloquent\Collection;
use App\Models\UserActions;
use App\User;
use Carbon\Carbon;

class UserService implements UserServiceInterface
{
   

    public function createUser( $type, $pt_id ) {
        $user = factory(SuperUser::class)->make([
            'pt_id'         => $pt_id,
            'first_name'    => null,
            'last_name'     => null,
            'email'         => null,
            'password'      => null
        ]);
        return $user;
    }

    /**
     * [deleteUser description]
     * @param  [type] $email [description]
     * @return [type]        [description]
     */
    public function deleteUser( $email ) {
        $query = [];
        $query[] = ['email', $email];
        return User::where( $query )->delete();
    }

    /**
     * [getUser description]
     * @param  [type] $fname [description]
     * @param  [type] $lname [description]
     * @param  [type] $email [description]
     * @return [type]        [description]
     */
    public function getUser( $email=null, $id=null, $slug=null ) {
        $query = [];
        if( $email ) {
            $query[] = ['email', $email];
        }

        if( $id ) {
            $query[] = ['id', $id];
        }

        if( $slug ) {
            $query[] = ['slug', $slug];
        }

        return User::where( $query )->get()->first();
    }

    /**
     * [getUsers description]
     * @param  [type] $name  [description]
     * @return [type]        [description]
     */
    public function getUsers( $type=null, $account=null ) {
        $query = [];

        if( $type ) {
            $query[] = ['type_id', $type];
        }

        if( $account ) {
            $query[] = ['account_id', $account];
        }

        $users = \DB::table('users')
            ->join('users_accounts', 'users.id', '=', 'users_accounts.user_id')
            ->select('users.*', 'users_accounts.*')
            ->where( $query )
            ->get();

        return new Collection( $users );

        // return User::all();
    }

    public function updateUsers( $user_id,$first_name=null,$last_name=null,$email=null,$password=null ){
        $query = [];
        if( $first_name ) {
            $query['first_name'] = $first_name;
        }
        if( $last_name ) {
            $query['last_name'] = $last_name;
        }
        if( $email ) {
            $query['email'] = $email;
        }
        if( $password ){
            $query['password'] = $password;
        }
        
        $updated = User::where('id',$user_id)->update($query);
        return $updated;
    }
    /**
     * [requestConfirmation description]
     * @param  [type] $registration [description]
     * @param  [type] $confirm_code [description]
     * @return [type]               [description]
     */
    private function requestConfirmation( $user, $link, $action ) {
        \Mail::send(['html'=>'emails.new'],
        ['link'=> $link,'action'=>$action],
        function( $message ) use ($user,$action) {
            $message->subject($action);
            $message->from('no-reply@provisiontracker.com', 'Provision Tracker');
            $message->to($user->email,
                        $user->first_name . ' ' .
                        $user->last_name);
        });
    }
    /**
     * [addUserAction description]
     * @param [type] $user_id       [description]
     * @param [type] $action        [description]
     * @param [type] $value         [description]
     * @param [type] $status        [description]
     * @param [type] $action_code   [description]
     */
    public function addUserAction( $user_id, $action, $value, $status, $action_code) {
        $user_action = \DB::table('user_actions')->insert([
            'user_id'       => $user_id,
            'action'        => $action,
            'value'         => $value,
            'status'        => $status,
            'code'          => $action_code,
            'expiry_date'   => Carbon::now()->addMonth(),

        ]);
        return $user_action;
    }

    /**
     * [getActionLink description]
     * @param  [type] $confirm_code [description]
     * @return [type]               [description]
     */
    private function getActionLink( $action,$confirm_code ) {
        $action = str_slug($action);
        return \Request::root() . "/action/confirm/$action/$confirm_code";
    }

    /**
    *[getActionDetails description]
    *@param     [type] $code [description]
    *@return    [type]       [description]
    */
    public function getUserActionDetails( $confirm_code ){
        $query[] = ['status','pending'];
        $query[] = ['code',$confirm_code];
        return UserActions::where($query)->first();
    }
    public function updateUserActionDetails( $user_action_id ){
        $query[] = ['id',$user_action_id];
        return UserActions::where($query)->update(['status'=>'actioned']);
    }
    public function updateInfo( $confirmation_code,$user,$action,$value ){
        
        $confirmation_link = $this->getActionLink( $action,$confirmation_code );
        $this->requestConfirmation( $user, $confirmation_link, $action );
        $user_action = $this->addUserAction($user->id, $action, $value, 'pending', $confirmation_code);
        return $user_action;
    }
   
   public function sendMail( $view,$data ){
        $send_mail = \Mail::send(['html'=>$view],
        ['data'=>$data],
        function( $message ) use ($data) {
            $message->subject($data['subject']);
            $message->from('no-reply@provisiontracker.com', 'Provision Tracker');
            $message->to($data['email'],
                        $data['first_name'] . ' ' .
                       $data['last_name']);
        });
        return $send_mail;
   }
}
