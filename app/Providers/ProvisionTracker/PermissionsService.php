<?php

namespace App\Providers\ProvisionTracker;
use Illuminate\Database\Eloquent\Collection;
use App\User;
use App\Models\Organisation;
use App\Models\Permissions;

class PermissionsService implements PermissionsServiceInterface
{
    /**
     * [addContext description]
     * @param Organisation $organisation [description]
     */
    public function addContext( Organisation $organisation ) {

    }

    /**
     * [getPermissionsFor description]
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function getPermissionsFor( User $user, $context ) {
        $query[] = ['user_id', $user->id];
        $query[] = ['actionable_context', $context];
        $results = \DB::table('permissions')
                        ->join('permissable_actions', 'permissions.action_id', '=', 'permissable_actions.id')
                        ->join('permissable_elements', 'permissions.actionable_element', '=', 'permissable_elements.id')
                        ->select('permissable_actions.label as can', 'permissable_elements.label as element')
                        ->where( $query )
                        ->get();
        $permissions = [];
        $actions = $this->getActions();
        $elements = $this->getElements();
        // We list all actions as empty (or not allowed) to start with,
        // then override with allowed permissions.
        // so it can read like: 
        // permissions['teachers']['add'] or
        // permissions['pupils']['view']
        foreach ($elements as $element ) {
            foreach ($actions as $action ) {
                $permissions[$element->label][$action->label] = 'denied';
            }
        }
        // Override with allowed permissions
        foreach ($results as $result ) {
            $permissions[$result->element][$result->can] = 'granted';
        }
        return $permissions;
    }

    /**
     * [clearPermissionsForUser description]
     * @param  User   $user [description]
     * @return [type]       [description]
     */
    public function clearPermissionsForUser( User $user ) {
        $query[] = ['user_id', $user->id];
        Permissions::where($query)->delete();
    }

    /**
     * [updatePermissionsFor description]
     * @param  User   $user         [description]
     * @param  [type] $permisssions [description]
     * @return [type]               [description]
     */
    public function updatePermissionsFor( User $user, $permisssions, $context ) {
        // Clear all permissions for this user first
        $this->clearPermissionsForUser($user);
        $actions = $this->getActions();
        // Go through all the available actions
        // and match them to the permissions that have been set
        foreach ($actions as $action ) {
            // If a permission has been set,
            // add it to the Db for that user
            if( isset($permisssions[$action->label]) ) {
                // get all the permissions for this action
                foreach ($permisssions[$action->label] as $key => $element ) {
                    $permission = new Permissions();
                    $permission->user_id = $user->id;
                    $permission->action_id = $action->id;
                    $permission->actionable_element = $this->getAction( null, $key)->id;
                    $permission->actionable_context = $context;
                    $permission->save();
                }
            }
        }
    }

    /**
     * [getActions description]
     * @return [type] [description]
     */
    public function getActions() {
        return \DB::table('permissable_actions')->get();
    }

    /**
     * [getAction description]
     * @param  [type] $id    [description]
     * @param  [type] $label [description]
     * @return [type]        [description]
     */
    public function getAction($id=null, $label=null) {
        $query = [];
        if( $id ) {
            $query[] = ['id', $id];
        }

        if( $label ) {
            $query[] = ['label', $label];
        }
        return \DB::table('permissable_elements')->where($query)->first();
    }

    /**
     * [getElements description]
     * @return [type] [description]
     */
    public function getElements() {
        return \DB::table('permissable_elements')->get();
    }
}
