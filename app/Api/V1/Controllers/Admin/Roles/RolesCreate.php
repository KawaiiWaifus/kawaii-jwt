<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Api\V1\Models\Permission,
    App\Api\V1\Models\Role,
    App\Api\V1\Models\User,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth,
    Log;

class RolesCreate extends Controller
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
     * Create Roles
     * @ Model Role
     * @@ App\Api\V1\Models\Role
     */
    public function CreateRole(Request $request){

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
}