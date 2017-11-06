<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Permission,
    App\Role, App\User,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth,
    JWTAuth, Tymon\JWTAuth\Exceptions\JWTException,
    Log;

class RolesControllers extends Controller
{
    
    public function index()
    {
        return response()->json(['auth'=> Auth::user(), 'users' => User::all()]);
    }

    /**
     * Create Roles
     * @ Class Role
     * @@ App\Role
     */
    public function createRole(Request $request){

        $role = new Role();
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->save();

        return response()->json(['body' => ['message' => "Role $role->name created with seuccess!"]]);

    }

    /**
     * Create Permissions
     * @ Class Permission
     * @@ App\Permission
     */
    public function createPermission(Request $request){

        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->display_name = $request->input('display_name');
        $permission->description = $request->input('description');
        $permission->save();

        return response()->json(['body' => ['message' => "Role $role->name created with seuccess!"]]);

    }

    /**
     * Add Role to User
     * @ Classes Role, User
     * @@ App\Role, App\User
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
        /**
         * add role to user
         */
        $result = $user->roles()
             ->attach($role->id);

        if ($result):
            return response()->json(['body' => ['message' => "Role: $role->name added to User: $user->name with success!"]]);
        else:
            return response()->json(['body' => ['message' => "Erro to add this role!"]]);
        endif;
    }

    /**
     * Add permissions to a Role
     * @ Classes Role, Permission
     * @@ App\Role, App\Permission
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
            return response()->json(['body' => ['message' => "Role: $role->name got permission $permission->name with success!"]]);
        else:
            return response()->json(['body' => ['message' => "Erro to add permission to role!"]]);
        endif;
    }

    /**
     * Sech Roles from a User
     * @ class User
     * @@ App\User
     */
    public function checkRoles(Request $request){
        $user = User::where('id', '=', $request->input('user_id'))->first();
        Log::info($user);
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

}
