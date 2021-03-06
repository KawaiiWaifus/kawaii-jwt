<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Api\V1\Models\Permission,
    App\Api\V1\Models\Role,
    App\Api\V1\Models\User,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth,
    Log;

class RolesControllers extends Controller
{
    /**
     * instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:api','role:admin.roles']);
    }


    /**
     * Add Role to User
     * @ Model Role, User
     * @@ App\Api\V1\Models\Role, App\Api\V1\Models\User
     */
    public function assignRole(Request $request){
        /**
         * select user by id
         */
        $user = User::where('id', '=', 
        $request->input('user_id'))
                ->first();
        /**
         * select role by name
         */
        $role = Role::where('name', '=', 
        $request->input('role'))
                ->first();

        // check if this user has the role
        if (Auth::user()->hasRole($request->input('role'))):
            return response()->json(['body' => ['message' => $user->name." already have this Role!", 'status' => 'warning']]);
        endif;

        /**
         * add role to user
         */
        $user->roles()
             ->attach($role->id);

        return response()->json(['body' => ['message' => "Role: $role->name added to User: $user->name with success!", 'status' => 'success']]);

    }

    /**
     * Add permissions to a Role
     * @ Model Role, Permission
     * @@ App\Api\V1\Models\Role, App\Api\V1\Models\Permission
     */
    public function attachPermission(Request $request){
        /**
         * select role by name
         */
        $role = Role::where('name', '=', 
        $request->input('role'))
                ->first();

        /**
         * select permission by name
         */
        $permission = Permission::where('name', '=', 
        $request->input('permmission'))
                ->first();

        $result = $role->attachPermission($permission);

        if ($result):
            return response()->json(['body' => ['message' => "Role: $role->name got Permission: $permission->name with success!", 'status' => 'success']]);
        else:
            return response()->json(['body' => ['message' => "Error to add permission to role!", 'status' => 'warning']]);
        endif;
    }

    /**
     * Sech Roles from a User
     * @ Model User
     * @@ App\Api\V1\Models\User
     */
    public function checkRoles(Request $request){
        $user = User::where('id', '=', $request->input('user_id'))->first();
        // Log::info($user);
        return response()->json([
            'body' => [
                "user" => $user,
                "Role-user" => $user->hasRole('user'),
                "Role-admin" => $user->hasRole('admin'),
                "Permission-edit.User" => $user->can('edit-user'),
                "Permission-list.Users" => $user->can('list-users')
            ]
        ]);
    }

    /**
     * @return object permissions for test
     */
    public function show(){

        if (!Auth::user()->ability(['admin.roles'], ['create'])):
            return 'no permission';
        endif;

        $perm = [];
        foreach (Auth::user()->roles()->get() as $p) {
            $perm += [
                $p->name => [
                  'permission' => $p->permissions[0]['id']
                ]
            ];
        }

        return response()->json([
            'body' => [
                "permissions" => $perm
            ]
        ]);
    }

}
