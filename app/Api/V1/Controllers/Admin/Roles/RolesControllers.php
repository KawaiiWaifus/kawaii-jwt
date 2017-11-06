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

        /**
         * select role by name
         */
        $role = Role::where('name', '=', 
        $request->input('name'))
                ->first();

        if ($role):

            return response()->json([
                'body' => [
                  'message' => "Role $role->name already exists and can not be added again!",
                  'status' => 'warning'
                ]]);

        else:

            $role = new Role();
            $role->name = $request->input('name');
            $role->display_name = $request->input('display_name');
            $role->description = $request->input('description');
            $role->save();

            return response()->json([
                'body' => [
                    'message' => "Role $role->name created with seuccess!",
                    'status' => 'success'
                ]]);

        endif;

    }

    /**
     * Create Permissions
     * @ Class Permission
     * @@ App\Permission
     */
    public function createPermission(Request $request){

        /**
         * select permission by name
         */
        $permission = Permission::where('name', '=', 
        $request->input('name'))
                ->first();
        
        if ($permission):

            return response()->json([
                'body' => [
                    'message' => "Permission $permission->name already exists and can not be added again!",
                    'status' => 'warning'
                    ]]);

        else:

            $permission = new Permission();
            $permission->name = $request->input('name');
            $permission->display_name = $request->input('display_name');
            $permission->description = $request->input('description');
            $permission->save();

            return response()->json([
                'body' => [
                    'message' => "Permission $permission->name created with seuccess!",
                    'status' => 'success'
                    ]]);

        endif;

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
            return response()->json(['body' => ['message' => "Role: $role->name added to User: $user->name with success!", 'status' => 'success']]);
        else:
            return response()->json(['body' => ['message' => "Erro to add this role!", 'status' => 'warning']]);
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
            return response()->json(['body' => ['message' => "Role: $role->name got Permission: $permission->name with success!", 'status' => 'success']]);
        else:
            return response()->json(['body' => ['message' => "Erro to add permission to role!", 'status' => 'warning']]);
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
