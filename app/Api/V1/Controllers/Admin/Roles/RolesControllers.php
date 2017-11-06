<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Permission,
    App\Api\V1\Models\Role,
    App\Api\V1\Models\User,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth,
    JWTAuth, Tymon\JWTAuth\Exceptions\JWTException,
    Log;

class RolesControllers extends Controller
{
    /*
     * instance.
     * @return void
    public function __construct()
    {
        $this->middleware('auth:api','role:admin', []);
    }
    */

    public function index()
    {
       // return response()->json(['auth'=> Auth::user(), 'users' => User::all()]);
    }

    /**
     * Create Roles
     * @ Model Role
     * @@ App\Api\V1\Models\Role
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
     * @ Model Permission
     * @@ App\Api\V1\Models\Permission
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
            return response()->json(['body' => ['message' => "Erro to add permission to role!", 'status' => 'warning']]);
        endif;
    }

    /**
     * Sech Roles from a User
     * @ Model User
     * @@ App\Api\V1\Models\User
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
