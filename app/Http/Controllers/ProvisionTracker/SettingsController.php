<?php

namespace App\Http\Controllers\ProvisionTracker;

use Illuminate\Http\Request;
use App\Providers\ProvisionTracker\UniqueIdServiceInterface;
use App\Providers\ProvisionTracker\Api\UserServiceInterface;
use App\Providers\ProvisionTracker\PermissionsServiceInterface;
use App\Providers\ProvisionTracker\Api\AccountServiceInterface;
use App\Http\Requests;
use App\Http\Requests\AddUserRequest;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function __construct( UserServiceInterface $userService,
                                 PermissionsServiceInterface $permissionsService,
                                 UniqueIdServiceInterface $idService,
                                 AccountServiceInterface $accountService) {
        $this->userService = $userService;
        $this->permissionsService = $permissionsService;
        $this->idService = $idService;
        $this->accountService = $accountService;
    }

    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index( Request $request ) {
        $data = [];
        return \View::make('app.settings.index', $data);
    }

    /**
     * [profile description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function profile( Request $request ) {
        $data = [];
        return \View::make('app.settings.profile', $data);
    }

    /**
     * [users description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function users( Request $request ) {
        $account_id = $request->session()->get('account');
        $data = [];
        $data['users'] = $this->userService->getUsers( 2, $account_id);
        return \View::make('app.settings.users', $data);
    }

    /**
     * [add descrption]
     * @param Request $request [description]
     * @return [type] [description]
     */

    public function add(Request $request){
        $data = [];
        
        // ------------------------------------------
        // Create the breadcrumb trail for this view
        $route_params['account_name'] = parent::getDefaultRouteParams($request, ['account_name'=>1]);
        $route_params['all'] = parent::getDefaultRouteParams($request);
        \Breadcrumbs::register('users/new', function($breadcrumbs) use ($route_params) {
            $breadcrumbs->push('Settings');
            $breadcrumbs->push('Users', route('settings/users', $route_params['all']));
            $breadcrumbs->push('Add User');
        });
        // ------------------------------------------
        return \View::make('app.settings.user-new', $data);
    }

    public function save( AddUserRequest $request ){
        $data = [];
        $data['first_name'] = $request->input('first_name');
        $data['last_name'] = $request->input('last_name');
        $slug = str_slug($data['first_name'].$data['last_name'], '-');
        $data['email'] = $request->input('email');
        $account_id = $request->input('account_id');
        $data['password'] = $this->idService->ptId();
        $add_user =  $this->userService->createUser( 2,  $this->idService->ptId() );
        $add_user->first_name = $data['first_name'];
        $add_user->last_name = $data['last_name'];
        $add_user->email = $data['email'];
        $add_user->slug = $slug;
        $add_user->password = \Hash::make( $data['password'] ); 
        $add_user->save();
        $create_relationship =  $this->accountService->createRelationship( $account_id, $add_user, 2 );
        $data['subject'] = 'Registeration Confirmation';
        $view = 'emails.registeration-confirmation';
        $confirm_reg = $this->userService->sendMail( $view,$data );
        return ($confirm_reg) ? 'User Created' : 'User Can\'t be Created' ;
    }


    /**
     * [permissions description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function permissions( Request $request ) {
        $user_slug = \Request::segment(5);
        $user = $this->userService->getUser( null, null, $user_slug );
        $context = $request->session()->get('organisation');
        $data = [];
        $data['user'] = $user;
        $data['permission_actions'] = $this->permissionsService->getActions();
        $data['permission_elements'] = $this->permissionsService->getElements();
        $data['permissions'] = $this->permissionsService->getPermissionsFor($user, $context);
        return \View::make('app.settings.permissions', $data);
    }

    /**
     * [updatePermissions description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updatePermissions( Request $request ) {
        $permissions = $request->input('permissions');
        $context = $request->input('context');
        $user = $this->userService->getUser( null, $request->input('id'), null);
        $this->permissionsService->updatePermissionsFor($user, $permissions, $context);
        return back();
    }

    /**
     * [schedule description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function schedule( Request $request ) {
        $data = [];
        return \View::make('app.settings.billing', $data);
    }

    /**
     * [billing description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function billing( Request $request ) {
        $data = [];
        return \View::make('app.settings.schedule', $data);
    }
}
