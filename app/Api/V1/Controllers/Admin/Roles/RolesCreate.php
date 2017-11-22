<?php

namespace App\Api\V1\Controllers\Admin\Roles;

use App\Role,
    Illuminate\Http\Request,
    App\Api\V1\Controllers\Controller,
    Illuminate\Support\Facades\Auth;

class RolesCreate extends Controller
{
    /**
     * instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:api']);
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
            $return = $role->save();

            return response()->json([
                'body' => ['id' => $role->id],
                'meta' => [],
                'status' => ['code' => 200, 'message' => "Role $role->name created with success!"]
                ]);

        endif;

    }
}